@extends('layout')
@section('content')
    <x-card class="p-10 rounded max-w-lg mx-auto mt-24"
    >
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit a Brand
            </h2>
            <p class="mb-4">Edit : {{$brand->name}}</p>
        </header>

        <form method="POST" action="/brands/{{$brand->id}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2"
                    >Materiel Name</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name"
                    placeholder="Example: Senior Laravel Developer"
                    value="{{ $brand->name }}"
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
                      <option value="{{$brand->state}}">{{$brand->state==1 ? 'Disponible':'Non Disponible'}}</option>
                       @php 
                        if ($brand->state==1){
                        echo '<option value="1">Non Disponible</option>';
                        }else{
                        echo '<option value="2">Disponible</option>';
                        }
                        @endphp       
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
                    value="{{ $brand->image }}"
                />
                <center><img
                    class="w-48 mr-6 mb-6"
                    src="{{$brand->image ? asset('storage/' . $brand->image) : asset('/images/no-image.png')}}"
                    alt=""
                /></center>

                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div> --}}

            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Update Brand
                </button>

                <a href="/" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
@endsection