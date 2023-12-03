@extends('back/layout/auth-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle : 'Reset Login')
    
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
      <div class="card card-md">
        <div class="card-body">
          <h2 class="h2 text-center mb-4">Reset password</h2>
          @livewire('autho-rest-password')

        </div>
        
      </div>
      
    </div>
  </div>
@endsection