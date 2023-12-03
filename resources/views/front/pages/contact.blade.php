
@extends('front.layout.page-layout')
@section('pageTitle',isset($pageTitle)?$pageTitle:'Welcom To ZianabBlog')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="breadcrumbs mb-4"> <a href="index.html">Home</a>
            <span class="mx-1">/</span>  <a href="#!">Contact</a>
        </div>
    </div>
   

    <div class="col-lg-4">
        <div class="pr-0 pr-lg-4">
            <div class="content">{{$info->blog_description}}
                <div class="mt-5">
                    <p class="h3 mb-3 font-weight-normal"><a class="text-dark" href="mailto:{{$info->blog_email}}">{{$info->blog_email}}</a>
                    </p>
                    <p class="mb-3"><a class="text-dark" href="#">+212{{$info->blog_phone}}</a>
                    </p>
                   
                </div>
            </div>
        </div>
    </div>

    <!-- contact.blade.php -->

<!-- Votre contenu existant -->
<div class="card-body">
    @if(Session::get('message_sent'))
        <div class="alert alert-success">
            {{ Session :: get('message_sent')}}
        </div>
    @endif
</div>
<div class="col-lg-6 mt-4 mt-lg-0">
    <form method="POST" action="{{route('contact.store')}}" class="row">
        @csrf <!-- Ajoutez cette ligne pour inclure le jeton CSRF -->
        <div class="col-md-6">
            <input type="text" class="form-control mb-4" placeholder="Name" name="name" id="name">
        </div>
        <div class="col-md-6">
            <input type="email" class="form-control mb-4" placeholder="Email" name="email" id="email">
        </div>
        <div class="col-12">
            <input type="text" class="form-control mb-4" placeholder="Subject" name="subject" id="subject">
        </div>
        <div class="col-12">
            <textarea name="message" id="message" class="form-control mb-4" placeholder="Type Your Message Here" rows="5"></textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-outline-primary" type="submit">Send Message</button>
        </div>
    </form>
</div>

</div>
@endsection