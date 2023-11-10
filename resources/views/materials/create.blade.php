@extends('layout-manage')
@section('content')
    <x-card class="p-10 rounded max-w-lg mx-auto mt-24"
    >
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create a Material
            </h2>
            <br>
        </header>

        <form method="POST" action="/materials" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label
                    for="code"
                    class="inline-block text-lg mb-2"
                    >Material Code</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="code"
                    value="{{old('code')}}"
                />

                @error('code')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2"
                    >Materiel Name</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name"
                    placeholder="Example: Senior Laravel Developer"
                    value="{{old('name')}}"
                />

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="location"
                    class="inline-block text-lg mb-2"
                    >Material Location</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="location"
                    placeholder="Example: Remote, Boston MA, etc"
                    value="{{old('location')}}"
                />

                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2"
                    >Contact Email</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="email"
                    value="{{old('email')}}"
                />

                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            
            <div class="mb-6">
                <label
                    for="website"
                    class="inline-block text-lg mb-2"
                >
                    Website/Application URL
                </label>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="website"
                    value="{{old('website')}}"
                />

                @error('website')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="brand" class="inline-block text-lg mb-2">
                    Brand
                </label>
                <select class="border border-gray-200 rounded p-2 w-full" id="brand" name="brand">
                      <option value="">~~SELECT~~</option>
                      @php
                        $brands = DB::table('brands')
                                    ->select('id', 'name')
                                    ->where('active', 1)
                                    ->get();

                        foreach ($brands as $brand) {
                            echo "<option value='" . $brand->id . "'>" . $brand->name . "</option>";
                        }
                      @endphp
                </select>  
                @error('brand')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror              
            </div>

            <div class="mb-6">
                <label for="category" class="inline-block text-lg mb-2">
                    Category
                </label>
                <select class="border border-gray-200 rounded p-2 w-full" id="category" name="category">
                      <option value="">~~SELECT~~</option>
                      @php
                        $categories = DB::table('categories')
                                    ->select('id', 'name')
                                    ->where('active', 1)
                                    ->get();

                        foreach ($categories as $category) {
                            echo "<option value='" . $category->id . "'>" . $category->name . "</option>";
                        }
                      @endphp
                </select>    
                @error('category')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror            
            </div>

            <div class="mb-6">
                <label
                    for="quantity"
                    class="inline-block text-lg mb-2"
                >
                    Quantity
                </label>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="quantity"
                    value="{{old('quantity')}}"
                />

                @error('quantity')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="rate"
                    class="inline-block text-lg mb-2"
                >
                    Rate
                </label>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="rate"
                    value="{{old('rate')}}"
                />

                @error('rate')
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

            <div class="mb-6">
                <label for="image" class="inline-block text-lg mb-2">
                    Material Image
                </label>
                <input
                    type="file"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="image"
                />
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="description"
                    class="inline-block text-lg mb-2"
                >
                    Material Description
                </label>
                <textarea
                    class="border border-gray-200 rounded p-2 w-full"
                    name="description"
                    rows="10"
                    placeholder="Include tasks, requirements, salary, etc"  
                >{{old('description')}}</textarea>

                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Create Material
                </button>

                <a href="/" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
@endsection