@extends('layout-manage')
@section('content')
    <x-card class="p-10 rounded max-w-lg mx-auto mt-24"
    >
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create a Brand
            </h2>
            <br>
        </header>

        <form method="POST" action="/brands" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label
                    for="name"
                    class="inline-block text-lg mb-2"
                    >Brand Name</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name"
                    value="{{old('name')}}"
                />

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <!-- <div class="mb-6">
                <label for="state" class="inline-block text-lg mb-2">
                    State
                </label>
                <select class="border border-gray-200 rounded p-2 w-full" id="state" name="state">
                      <option value="0">~~SELECT~~</option>
                      <option value="1">Disponible</option>
                      <option value="2">Non Disponible</option>          
                </select>  
                @error('state')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror              
            </div> -->

            {{-- <div class="mb-6">
                <label for="image" class="inline-block text-lg mb-2">
                    Brand Image
                </label>
                <input
                    type="file"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="image"
                />
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div> --}}

            <div class="mb-6 mt-12">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Create Brand
                </button>

                <a href="../" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
@endsection