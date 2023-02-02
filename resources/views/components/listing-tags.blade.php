

@props(['tagsCSV'])
{{-- retrieve an string of tags as a props --}}


@php
  // Convert comma separated string into an array
  $tags = explode(',', $tagsCSV); 

@endphp


<ul >

  @foreach ($tags as $tag)
    <li class="flex items-center justify-content bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"> 
      <a href="/?tag={{$tag}}"> {{$tag}} </a>
    </li>
      
  @endforeach

</ul>