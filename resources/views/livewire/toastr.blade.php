<div>
    <script>
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        };
        toastr.success("{{ $message }}");
    </script>
</div>

