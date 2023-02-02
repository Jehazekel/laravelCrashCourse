<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Laragigs</title>
</head>

<link rel="icon" href="images/favicon.ico" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<script src="https://cdn.tailwindcss.com" defer></script>
<script src="//unpkg.com/alpinejs" defer></script>
<body>

    <x-flash-message />
    {{-- <h2> {{ $heading }} </h2> --}}
    {{-- Components use '{{$slot}}' to render children ; --}}
    {{$slot}}
    


</body>
</html>