<x-layoutComponent>
  <x-card class="p-10 max-w-lg mx-auto mt-24">
    <header class="text-center">
      <h2 class="text-2xl font-bold uppercase mb-1">Create a Gig</h2>
      <p class="mb-4">Post a gig to find a developer</p>
    </header>

    {{-- For form to obtain the prev values on error, we use 'value={{old('inputName')}}' --}}
    <form method="POST" action="/email" enctype="multipart/form-data">
      {{-- '@csrf' prevents persons from havoing a form on another website to submit to this form --}}
      @csrf

      <div class="mb-6">
        <label for="title" class="inline-block text-lg mb-2">Job Title</label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
          placeholder="Example: Senior Laravel Developer" value="{{old('title')}}" />

        @error('title')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="location" class="inline-block text-lg mb-2">Subject</label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="subject"
          placeholder="Example: Random text" value="{{old('subject')}}" />

        @error('subject')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2">
          Contact Email
        </label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email" value="{{old('email')}}" />

        @error('email')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>


      <div class="mb-6 align-items-center">
        <button class="bg-[red] text-white rounded py-2 px-4 hover:bg-black">
          Send Email
        </button>

        <a href="/" class="text-black ml-4"> Back </a>
      </div>
    </form>
  </x-card>
</x-layoutComponent>