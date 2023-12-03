@extends('back.layout.page-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Settings')
@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="page-title">
            Settings
        </h2>
    </div>
</div>
<div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
        <li class="nav-item" role="presentation">
          <a href="#tabs-home-8" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">General Settings</a>
        </li>
        <li class="nav-item" role="presentation">
          <a href="#tabs-profile-8" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Logo & Favicon</a>
        </li>
        <li class="nav-item" role="presentation">
          <a href="#tabs-activity-8" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Social Media</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane fade active show" id="tabs-home-8" role="tabpanel">
            @livewire('author-general-settings')

        </div>
        <div class="tab-pane fade" id="tabs-profile-8" role="tabpanel">
          <div class="row">
            <div class="col-md-6">
              <h4>Set blog logo</h4>
              <?php
                $imageData = \App\Models\Setting::find(1);
                $logoFileName = $imageData->blog_logo;

              ?>
              <div class="mb-2" style="max-width:200px">
                <img id="logo-image-preview" class="img-thumbnail" src="{{ asset('/back/dist/img/logo-favicon/' . $logoFileName) }}" alt="Image Preview" data-original="{{ asset('/back/dist/img/logo-favicon/' . $logoFileName) }}">
              </div>
              <form  method="POST"  action="{{route('authorchange-blog-logo')}}" id="changeBlogLogoForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                  <input type="file"  accept="image/*" name="blog_logo" id="blogLogoInput" class="form-control">
                </div>
                <button class="btn btn-primary">Save Changes</button>
              </form>
            </div>
            <div class="col-md-6">
              <h4>Set blog Favicon</h4>
                <?php
                    $imageData = \App\Models\Setting::find(1);
                    $faviconFileName = $imageData->blog_favicon;

                ?>
              <div class="mb-2" style="max-width:200px">
                  <img id="favicon-image-preview" class="img-thumbnail" src="{{ asset('/back/dist/img/logo-favicon/' . $faviconFileName) }}" alt="Favicon Preview" data-original="{{ asset('/back/dist/img/logo-favicon/' . $faviconFileName) }}">
              </div>
              <form method="POST" action="{{ route('authorchange-blog-favicon') }}" id="changeBlogFaviconForm" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-2">
                      <input type="file" accept=".ico" name="blog_favicon" id="blogfaviconInput" class="form-control">
                  </div>
                  <button class="btn btn-primary">Save Changes</button>
              </form>
          </div>
          
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="tabs-activity-8" role="tabpanel">
         @livewire('author-blog-social-media-form')
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
      var imagePreview = document.getElementById('logo-image-preview');
      var imageInput = document.getElementById('blogLogoInput');
      
      var viewer = new Viewer(imagePreview, {
          inline: false,
          imageShape: 'rectangular'
      });

      imageInput.addEventListener('change', function () {
          var selectedFile = imageInput.files[0];

          if (selectedFile) {
              var imageUrl = URL.createObjectURL(selectedFile);
              imagePreview.src = imageUrl;
              viewer.update();
          }
      });
  });

  $('#changeBlogLogoForm').submit(function(e){
    e.preventDefault(); 
    var form = this;
    $.ajax({
    url: $(form).attr('action'),
    method: $(form).attr('method'),
    data: new FormData(form),
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    processData: false,
    contentType: false,
      
      beforeSend: function() {
        toastr.remove();
      },
      success: function(data) { // Correction de la position de la parenthèse
        toastr.success(data.msg);
        $(form)[0].reset();
        Livewire.dispatch('updateTopHeader');
      },
      error: function(data) { // Correction de la position de la parenthèse
        toastr.error(data.msg);
      }
    });
  });
  document.addEventListener('DOMContentLoaded', function () {
    var faviconPreview = document.getElementById('favicon-image-preview');
    var faviconInput = document.getElementById('blogfaviconInput');
    
    var viewer = new Viewer(faviconPreview, {
        inline: false,
        imageShape: 'rectangular'
    });

    faviconInput.addEventListener('change', function () {
        var selectedFile = faviconInput.files[0];

        if (selectedFile) {
            var imageUrl = URL.createObjectURL(selectedFile);
            faviconPreview.src = imageUrl;
            viewer.update();
        }
    });
});

$('#changeBlogFaviconForm').submit(function(e){
    e.preventDefault(); 
    var form = this;
    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        
        beforeSend: function() {
            toastr.remove();
        },
        success: function(data) {
            toastr.success(data.msg);
            $(form)[0].reset();
            Livewire.dispatch('updateTopHeader');
        },
        error: function(data) {
            toastr.error(data.msg);
        }
    });
});

</script>

@endpush