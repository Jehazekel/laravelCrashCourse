<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Laragigs</title>
</head>

<script src="https://cdn.tailwindcss.com" defer></script>
<script src="//unpkg.com/alpinejs" defer></script>
<body>
  
  {{-- nav bar --}}
    <nav class="flex justify-between items-center mb-4">
      <a href="/"><img class="w-24" src="{{asset('images/logo.png')}}" alt="" class="logo" /></a>
      <ul class="flex space-x-6 mr-6 text-lg">
        @auth
        <li>
          <span class="font-bold uppercase">
            Welcome {{auth()->user()->name}}
          </span>
        </li>
        <li>
          <a href="/listings/manage" class="hover:text-laravel"><i class="fa-solid fa-gear"></i> Manage Listings</a>
        </li>
        <li>
          <form class="inline" method="POST" action="/logout">
            @csrf
            <button type="submit">
              <i class="fa-solid fa-door-closed"></i> Logout
            </button>
          </form>
        </li>
        @else
        <li>
          <a href="/register" class="hover:text-laravel"><i class="fa-solid fa-user-plus"></i> Register</a>
        </li>
        <li>
          <a href="/login" class="hover:text-laravel"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
        </li>
        @endauth
      </ul>
    </nav>
    
        <h2> {{ $heading }} </h2>
        <x-flash-message />
        {{-- TO import html as a section with the tag 'name'  use '@yield('name') '--}}
        @yield('content')

    <a href='/listings/create' > Create </a>
</body>
</html>