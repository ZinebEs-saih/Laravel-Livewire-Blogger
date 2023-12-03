@extends('back/layout/auth-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle : 'Forgot Password')
    
@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-4">
        <?php
            $imageData = \App\Models\Setting::find(1);
            $logoFileName = $imageData->blog_logo;

          ?>
        <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ asset('/back/dist/img/logo-favicon/' . $logoFileName) }}" height="36" alt=""></a>
     
      </div>
      @livewire('autho-forgot-password')
      <div class="text-center text-muted mt-3">
        Forget it, <a href="{{ route('authorLogin') }}">send me back</a> to the sign in screen.
      </div>
    </div>
  </div>
@endsection