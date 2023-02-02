
{{-- Accessing values in a component we use '@props(['variable'] )' --}}

@props(['listing'])

{{-- To pass class to a custom component we set 'class' & merge within the component--}}
<x-card class="p-24">

    <h2> {{ $listing['title'] }} </h2>
    <p> {{ $listing['description'] }} </p>
    <p> {{ $listing->company }} </p>
    
    <a href="/listings/{{$listing->id}}/edit" > <i class="fa-solid fa-pencil"></i> Edit </a>
    
    {{-- TO added delete we use a form --}}
    <form action="/listings/{{$listing->id}}" method="POST">
        @csrf
        @method('DELETE')

        <button class="text-red-500"> <i class="fa-solid fa-trash"></i> Delete </button >

    </form>
    <x-listing-tags :tagsCSV='$listing->tags' />

</x-card>
