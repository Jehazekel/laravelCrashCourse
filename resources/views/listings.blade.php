{{-- TO use a layout call "@extends('layout')" & define the section by "@section('content')" --}}
@extends('layout')  
@section('content')

{{-- to import html as a partial into the current file at this location--}}
@include('partials._hero')  

    {{-- Instead of If we can use 'unless' // which is an if else --}}


    {{-- @if (count($listings) == 0)
    <p> No Listings found </p>
    
    @endif --}}




    @unless(count($listings) == 0)
        @foreach ($listings as $listing)
        <div>

          {{-- <img class="hidden w-48 mr-6 md:block " height="150" width="100s" src="{{ asset('images/success.png')}}" /> --}}
          <img class="hidden w-48 mr-6 md:block " height="150" width="100s" src="{{ $listing->logo ? asset('storage/'.$listing->logo) : asset('images/success.png')}}" />
          
            {{-- <h2>
                {{ $listing['title'] }}  
                <a href="/listings/{{ $listing['id'] }}"> {{ $listing['title'] }} </a>
            </h2>
            <p> {{ $listing['description'] }} </p> --}}
            
            {{-- Using a custom component : to pass vairables we use `:propName="$variable"`--}}
            {{-- However strings can simply use "propName="text" w/o the colon ( : ) --}}
            <x-listing-card :listing="$listing" />
        </div>
            @endforeach
    @else
        <p> No Listings </p>
    @endunless

        <div class="mt-6 p-4">
            {{-- to add pagination --}}
            {{$listings ->links()}}
        </div>

@endsection
