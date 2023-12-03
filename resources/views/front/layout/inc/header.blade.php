<header class="navigation">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light px-0">
        <a class="navbar-brand order-1 py-0" href="/">
          <img loading="preload" decoding="async" class="img-fluid" src="{{ asset('/back/dist/img/logo-favicon/' . blogInfo()->blog_logo) }}" alt="{{ blogInfo()->blog_name }}" style="max-width: 200px">
        </a>
        <div class="navbar-actions order-3 ml-0 ml-md-4">
          <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button" data-toggle="collapse"
            data-target="#navigation"> <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <form action="{{route('search_post')}}" class="search order-lg-3 order-md-2 order-3 ml-auto">
          <input id="search-query" name="query" value="{{Request('query')}}" type="search" placeholder="Search..." autocomplete="off">
        </form>
        <div class="collapse navbar-collapse text-center order-lg-2 order-4" id="navigation">
          <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
            <li class="nav-item"> <a class="nav-link" href="/">Home</a>
            </li>
            @foreach (\App\Models\Category::whereHas('subcategories', function($q){
              $q->whereHas('posts');
            })->orderBy('ordering','asc')->get() as $category)
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     {{ $category->category_name }}
                  </a>
                <div class="dropdown-menu">
                  @foreach (\App\Models\SubCategorie::where('parent_categorie',$category->id)->whereHas('posts')
                  ->orderBy('ordering','asc')->get() as $subcategory)
                        <a class="dropdown-item" href="{{route('category_post',$subcategory->slug)}}">{{$subcategory->subcategorie_name}}</a>
                  @endforeach
                  
                </div>
              </li>
            @endforeach
            <li class="nav-item">
            @foreach (\App\Models\SubCategorie::where('parent_categorie',0)->whereHas('posts')
            ->get() as $subcategory) 
                  <a class="nav-link" href="{{route('category_post',$subcategory->slug)}}">{{$subcategory->subcategorie_name}}</a>
            @endforeach
            </li>
            <li class="nav-item"> <a class="nav-link" href="{{route('contact')}}">Contact</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
