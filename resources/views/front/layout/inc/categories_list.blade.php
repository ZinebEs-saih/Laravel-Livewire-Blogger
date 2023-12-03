@foreach (categories() as $item)
<li><a href="{{route('category_post',$item->slug)}}">{{ Str::ucfirst($item->subcategorie_name)}}<span class="ml-auto">({{ $item->posts->count()}})</span></a>
</li>
@endforeach