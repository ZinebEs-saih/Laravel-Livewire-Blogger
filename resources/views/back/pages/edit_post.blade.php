@extends('back.layout.page-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'Add new post')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Edit Post
          </h2>
        </div>
      </div>
    </div>
  </div>
  <form method="Post" id="EditPost" action="{{route('authorpostsupdatePost',['post_id'=>Request('post_id')])}}" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
           <div class="row">
            <div class="col-md-9">
                <div class="mb-3">
                    <div class="form-label">Post title</div>
                    <input type="text" class="form-control" name="post_title" placeholder="Enter post title " value="{{$post->post_title}}" >
                    <span class="text-danger error-text post_title_error"></span>
                </div>
                <div class="mb-3">
                    <div class="form-label">Post content</div>
                    <textarea class="form-control" name="post_content" placeholder="content... " rows="6" id="post_content" >{!!$post->post_content!!}</textarea>
                    </textarea>   
                    <span class="text-danger error-text post_content_error"></span>

                </div> 
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <div class="form-label">Post Category</div>
                <select class="form-select" name="post_category">
                    <option value="">No Selected</option>
                    @foreach (\App\Models\SubCategorie::all() as $category)
                        <option value="{{$category->id}}" {{$post->category_id==$category->id ? 'selected' : ''}}>{{$category->subcategorie_name}}</option>
                    @endforeach
                    
                </select>
                <span class="text-danger error-text post_category_error"></span>

            </div>
            <div class="mb-3">
                <div class="form-label">Featured Image</div>
                <input type="file" class="form-control" name="featured_image" id="featured_image">
                <span class="text-danger error-text featured_image_error"></span>
            </div>
            <div class="image_holder mb-2" style="max-width: 250px">
            <img src="/storage/images/post_images/thumbnails/resized_{{$post->featured_image}}" alt="" class="img-thumbnail" id="image-previewer" data-ijabo-default-img='' >
            </div>
            <div class="mb-3">
                <div class="form-label">Post tags</div>
                <input type="text" class="form-control" id="" name="post_tags"value="{{$post->post_tags}}" >
            </div>
            <button type="submit" class="btn btn-primary">Update post</button>
        </div>
           </div>
        </div>
    </div>
  </form>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#post_content').summernote({
            placeholder: 'Content.....',
            tabsize: 2,
            height: 100
        })
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
      var imagePreview = document.getElementById('image-previewer');
      var imageInput = document.getElementById('featured_image');
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
    })

$('form#EditPost').submit(function(e){
    e.preventDefault();
    toastr.remove();
    var form = this;
    var formData = new FormData(form); 
    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: formData, 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false, 
        dataType: 'json',
        
        beforeSend: function() {
            $(form).find('span.error-text').text('');
            toastr.remove();
        },
        success: function(response) {
            toastr.remove();
            if (response.code == 1) {
                toastr.success(response.msg);
            } else {
                toastr.error(response.msg);
            }
        },
        error: function(response) {
            toastr.remove();
            $.each(response.responseJSON.errors, function(prefix, val) {
                $(form).find('span.' + prefix + '_error').text(val[0]);
            });
        }
    });
});

</script>

<style>
    /* Adjust the height and width of the CKEditor iframe */
    .ck.ck-editor__editable {
      height: 100px; /* Adjust the height as needed */
      width: 100%; /* Adjust the width as needed */
    }
  </style>

@endpush
