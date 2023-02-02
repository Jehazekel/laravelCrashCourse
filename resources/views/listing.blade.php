<!DOCTYPE html>
<html>

<body>
  

    {{-- Instead of If we can use 'unless' // which is an if else --}}


    {{-- @if (count($listings) == 0)
    <p> No Listings found </p>
    
    @endif --}}



    <h2> {{ $listing['title'] }} </h2>
    <p> {{ $listing['description'] }} </p>
    <p> {{ $listing->company }} </p>

</body>

</html>
