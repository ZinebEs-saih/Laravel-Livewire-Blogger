
<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>
	<meta charset="utf-8">
	<title>@yield('pageTitle')</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
	@yield('meta_tags')
    <link rel="shortcut icon" href="{{ asset('/back/dist/img/logo-favicon/' .blogInfo()->blog_favicon) }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('/back/dist/img/logo-favicon/' . blogInfo()->blog_favicon) }}" type="image/x-icon">
  
  <!-- theme meta -->
  <meta name="theme-name" content="reporter" />

	<!-- # Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- # CSS Plugins -->
	<link rel="stylesheet" href="/front/plugins/bootstrap/bootstrap.min.css">
	@stack('stylesheets')
	<!-- # Main Style Sheet -->
	<link rel="stylesheet" href="/front/css/style.css">
</head>

<body>

@include('front.layout.inc.header')

<main>
  <section class="section">
    <div class="container">
        @yield('content')
    </div>
    <div>
      </div>
    </div>
  </section>
</main>

@include('front.layout.inc.footer')


<!-- # JS Plugins -->
<script src="/front/plugins/jquery/jquery.min.js"></script>
<script src="/front/plugins/bootstrap/bootstrap.min.js"></script>
@stack('scripts')
<!-- Main Script -->
<script src="js/script.js"></script>

</body>
</html>
