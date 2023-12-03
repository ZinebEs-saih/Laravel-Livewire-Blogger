@extends('back.layout.page-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'Authors')
@section('content')
<style>
    .custom-swal-popup {
      font-size: 0.85rem;
    }
  </style>
    @livewire('authors-setting')
@endsection
@push('scripts')
<script>
   $(window).on('hidden.bs.modal', function() {
    livewire.dispatch('resetForm');
    });
    window.addEventListener('hide_add_author_modal', function() {
        $('#add_author_new').modal('hide');
    });
    window.addEventListener('showEditAuthorModal', function() {
        $('#edit_author').modal('show');
    });
    window.addEventListener('hide_edit_author_modal', function() {
        $('#edit_author').modal('hide');
    });

/*$(window).on('deleteAuthor', function() {
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
    }).then(function(result) {
        if (event.detail && typeof event.detail === 'object' && 'id' in event.detail) {
    console.log(event.detail.id);
    Livewire.dispatch('deleteAuthorAction', event.detail.id);
} else {
    console.error('Propriété "id" non trouvée dans event.detail');
}
    });
});*/
window.addEventListener('deleteAuthor', function() {
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
            Livewire.dispatch('deleteAuthorAction',{id:id});
        }
    });
});








</script>
    
@endpush