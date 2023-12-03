@extends('back.layout.page-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'All Post')
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
                        All Posts
                    </h2>
                </div>
        </div>
    </div>
</div>
@livewire('all-posts')
@endsection
@push('scripts')
    <script>
        window.addEventListener('deletePost', function() {
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
                    Livewire.dispatch('deletePostAction',{id:id});
                }
            });
        });
    </script>
@endpush