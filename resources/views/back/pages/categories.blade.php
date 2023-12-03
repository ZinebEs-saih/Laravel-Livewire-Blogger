@extends('back.layout.page-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'Categories')
@section('content')
<style>
  .custom-swal-popup {
      font-size: 0.85rem;
    }
</style>
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Categoris & Subcategories
          </h2>
        </div>
      </div>
    </div>
</div>
 @livewire('categories')
@endsection
@push('scripts')
    <script>
      window.addEventListener('hideCategoriesModal',function(e){
        $('#modalCategory').modal('hide');
      })
      window.addEventListener('showCatgoriesModal',function(e){
        $('#modalCategory').modal('show');
      })
      window.addEventListener('hideSubCategoriesModal',function(e){
        $('#modalSubCategorie').modal('hide');
      })
      window.addEventListener('showSubCatgoriesModal',function(e){
        $('#modalSubCategorie').modal('show');
      })
      $('#modalCategory , #modalSubCategorie').on('hidden.bs.modal',function(e){
        Livewire.dispatch('resetModalForm');
      });
      
    </script>
    <script>
    window.addEventListener('deleteCategorie', function() {
      let id = event.detail[0].id;
      swal.fire({
          title: event.detail[0].title,
          imageWidth: 48,
          imageHeight: 48,
          html: event.detail[0].html,
          showCancelButton: true,
          showCloseButton: true,
          confirmButtonText: 'Yes, Delete!',
          cancelButtonText: 'No, Cancel',
          cancelButtonColor: '#d33',
          confirmButtonColor: '#5cb85c',
          width: 300,
          allowOutsideClick: false,
          customClass: {
              container: 'custom-swal-container', // Ajoutez une classe personnalisée pour le conteneur de la boîte de dialogue
              popup: 'custom-swal-popup', // Ajoutez une classe personnalisée pour la boîte de dialogue
              title: 'custom-swal-title', // Ajoutez une classe personnalisée pour le titre
              html: 'custom-swal-html', // Ajoutez une classe personnalisée pour le contenu HTML
          }
        }).then(function(result) {
            if (result.value) {
                Livewire.dispatch('deleteCategoryAction',{id:id});
            }
        });
    });
    </script>
  <script>
      window.addEventListener('deleteSubCategorie', function() {
      let id = event.detail[0].id;
      swal.fire({
          title: event.detail[0].title,
          imageWidth: 48,
          imageHeight: 48,
          html: event.detail[0].html,
          showCancelButton: true,
          showCloseButton: true,
          confirmButtonText: 'Yes, Delete!',
          cancelButtonText: 'No, Cancel',
          cancelButtonColor: '#d33',
          confirmButtonColor: '#5cb85c',
          width: 300,
          allowOutsideClick: false,
          customClass: {
              container: 'custom-swal-container', // Ajoutez une classe personnalisée pour le conteneur de la boîte de dialogue
              popup: 'custom-swal-popup', // Ajoutez une classe personnalisée pour la boîte de dialogue
              title: 'custom-swal-title', // Ajoutez une classe personnalisée pour le titre
              html: 'custom-swal-html', // Ajoutez une classe personnalisée pour le contenu HTML
          }
        }).then(function(result) {
            if (result.value) {
                Livewire.dispatch('deleteSubCategoryAction',{id:id});
            }
          });
    });
    $('table tbody#sortable_category').sortable({
      update: function(event, ui) {
          $(this).children().each(function(index) {
              if ($(this).attr('ordering') !== (index+1)) {
                  $(this).attr('ordering',(index+1)).addClass("updated");
              }
          });

          var positions = [];
          $(".updated").each(function() {
              positions.push([$(this).attr("data-index"), $(this).attr("ordering")]);
              $(this).removeClass("updated");
          });
          window.Livewire.dispatch("updateCategoryOrdering",{ positions});
          //alert(positions);
    }

    });


    $('table tbody#sortable_Subcategory').sortable({
      update: function(event, ui) {
          $(this).children().each(function(index) {
              if ($(this).attr('ordering') !== (index+1)) {
                  $(this).attr('ordering',(index+1)).addClass("updated");
              }
          });

          var positions = [];
          $(".updated").each(function() {
              positions.push([$(this).attr("data-index"), $(this).attr("ordering")]);
              $(this).removeClass("updated");
          });
          window.Livewire.dispatch("updateSubCategoryOrdering",{ positions});
          //alert(positions);
    }

    });

      
  </script>
@endpush