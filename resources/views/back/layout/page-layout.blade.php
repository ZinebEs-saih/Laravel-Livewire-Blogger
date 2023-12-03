<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('pageTitle')</title>
  
    <!-- CSS files -->
    <link href="/back/dist/css/tabler.min.css?1684106062" rel="stylesheet"/>
    <link href="/back/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet"/>
    <link href="/back/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet"/>
    <link href="/back/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet"/>
    

    
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <?php
        $imageData = \App\Models\Setting::find(1);
        $logoFileName = $imageData->blog_favicon;

    ?>
    <link rel="shortcut icon" href="{{ asset('/back/dist/img/logo-favicon/' . $logoFileName) }}" type="image/x-icon">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link href="/back/dist/libs/ijaboCropTool/ijaboCropTool.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.8.0/viewer.min.css">
    <link href="/back/dist/css/demo.min.css?1684106062" rel="stylesheet"/>
    <link rel="stylesheet" href="/jquery-ui-1.13.2/jquery-ui.css">
    <link rel="stylesheet" href="/jquery-ui-1.13.2/jquery-ui.min.css">
    <link rel="stylesheet" href="/jquery-ui-1.13.2/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/jquery-ui-1.13.2/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="/amsify/amsify.suggestags.css">
    <link rel="stylesheet" href="/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    @stack('stylesheets')

    @livewireStyles
    
    <style>
      @import url('https://rsms.me/inter/inter.css');
      
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    
    </style>
    
  </head>
  <body >

    <script src="/back/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
      <!-- Navbar -->
      <div class="wrapper">
        @include('back.layout.inc.header')

        <!-- Page header -->
        <div class="page-wrapper">
          <div class="container-xl">
            @yield('pageheader')
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            @yield('content')
          </div>
        </div>
        @include('back.layout.inc.footer')
      </div>
    </div>
    

		
    <!-- Libs JS -->
    <script src="/back/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
    <script src="/back/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062" defer></script>
    <script src="/back/dist/libs/jsvectormap/dist/maps/world.js?1684106062" defer></script>
    <script src="/back/dist/libs/jsvectormap/dist/maps/world-merc.js?1684106062" defer></script>
    <script src="/back/dist/js/tabler.min.js?1684106062" defer></script>
    <script src="/back/dist/js/demo.min.js?1684106062" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('back/dist/libs/ijaboCropTool/ijaboCropTool.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.8.0/viewer.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="/jquery-ui-1.13.2/jquery-ui.min.js"></script>
    <script src="/jquery-ui-1.13.2/jquery-ui.min.js"></script>
    <script src="/amsify/jquery.amsify.suggestags.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  $('input[name="post_tags"]').amsifySuggestags();
  
  window.addEventListener('toastr:info', function (event) {
    if (event.detail.length > 0) {
      displayToastr('info', event.detail[0].message);
    }
  });

  window.addEventListener('toastr:success', function (event) {
    if (event.detail.length > 0) {
      displayToastr('success', event.detail[0].message);
    }
  });

  window.addEventListener('toastr:error', function (event) {
    if (event.detail.length > 0) {
      displayToastr('error', event.detail[0].message);
    }
  });

  function displayToastr(type, message) {
    toastr[type](message);
    console.log('Message content:', message);
  }
</script>

 

    @stack('scripts')
    @livewireScripts

    
    
    
    
    <!-- Tabler Core -->
    
    
  
    
  
    
  </body>
</html>
