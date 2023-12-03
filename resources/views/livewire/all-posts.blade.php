<div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="" class="form-label">Searche</label>
            <input type="text" wire:model.live.debounce.150ms="search" class="form-control" placeholder="Keyword...." >
        </div>
        <div class="col-md-2 mb-3">
            <label for="" class="form-label">Category</label>
            <select name="" id="" class="form-select" wire:model.live='category'>
                <option value="">--- No Selected ----</option>
                @foreach (\App\Models\SubCategorie::whereHas('posts')->get() as $category)
                <option value="{{$category->id}}">{{$category->subcategorie_name}}</option>
                @endforeach
                
           
            </select>
        </div>
        @if(auth()->user()->type==1)
        <div class="col-md-3 mb-3">
            <label for="" class="form-label">Author</label>
            <select name="" id="" class="form-select" wire:model.live="author">
                <option value="">--- No Selected ----</option>
                @foreach (\App\Models\User::whereHas('posts')->get() as $author)
                    <option value="{{$author->id}}">{{$author->name}}</option>
                @endforeach
                
            </select>
        </div>
        @endif
        <div class="col-md-3 mb-3">
            <label for="" class="form-label">OrderBy</label>
            <select name="" id="" class="form-select" wire:model.live="orderby">
                <option value="asc">ASC</option>
                <option value="desc">DESC</option>
            </select>
        </div>
    </div>
    <div class="row row-cards">
        @forelse ($posts as $post)
        <div class="cod-md-6 col-lg-3">
            <div class="card">
                <img src="/storage/images/post_images/thumbnails/resized_{{$post->featured_image}}" alt="" class="card-img-top">
                <div class="card-body p-2">
                    <h3 class="m-0 mb-1">{{$post->post_title}}</h3>
                </div>
                <div class="d-flex">
                    
                    <a href="{{route('authorpostseditPost',['post_id'=>$post->id])}}" class="card-btn">Edit</a>
                    <a href="" wire:click.prevent="deletePost({{ $post->id }})" class="card-btn">Delete</a>

                </div>
            </div>
        </div>
        @empty
            <span class="text-danger">No post(s) found !</span>
        @endforelse 
    </div>
    <div class="d-block mt-2">
        {{$posts->links('livewire::simple-bootstrap')}}
    </div>
</div>