
@if( session()->has('success') )

{{-- Below x-data & x-init uses alpine to render a disappearing message --}}
  <div x-data="{show : true}" x-init="setTimeout( ()=> show = false, 3000)" x-show="show"
   class="fixed top-0 transform bg-laravel px-48 py-2 translate-x-1/2 text-white">

    <p>
      {{ session('success')}}
    <p>
  </div>

@endif