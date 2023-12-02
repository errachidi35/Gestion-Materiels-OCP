@extends('layout')

@section('content')
@include('partials\_search')

<a href="javascript:history.back()" class="inline-block text-black ml-4 mb-4"
    ><i class="fa-solid fa-arrow-left"></i> Back
</a>
<div class="mx-4">
    <x-card class="bg-black">
         <div
            class="flex flex-col items-center justify-center text-center"
        >
            <img
                class="w-48 mr-6 mb-6"
                src="{{$material->image ? asset('storage/' . $material->image) : asset('/images/no-image.png')}}"
                alt=""
            />

            <div class="text-xl font-bold mb-4">{{$material->code}}</div>
            <h3 class="text-2xl mb-4">{{$material->name}} {{--({{$material->toArray()['category']['name']}})--}}</h3>
            <div class="text-xl font-medium mb-4">{{$material->toArray()['brand']['name']}}</div>
            <div class="text-xl font-medium mb-4">Price : {{$material->rate}} DH</div>
            {{-- <x-material-tags :tagsCsv="$material->tags" /> --}}
            <div class="text-lg my-4">
                <i class="fa-solid fa-location-dot"></i> {{$material->location}}
            </div>
            <div class="border border-gray-200 w-full mb-6"></div>
            <div>
                <h3 class="text-3xl font-bold mb-4">
                    Description
                </h3>
                <div class="text-lg space-y-6">
                    {{$material->description}}

                    <a
                        href="mailto:{{$material->email}}"
                        class="block bg-laravel text-white mt-6 py-2 px-4 rounded-xl hover:opacity-80"
                        ><i class="fa-solid fa-envelope"></i>
                        Contact Employer</a
                    >

                    <a
                        href="{{$material->website}}"
                        target="_blank"
                        class="block bg-black text-white py-2 rounded-xl hover:opacity-80"
                        ><i class="fa-solid fa-globe"></i> Visit
                        Website</a
                    >
                </div>
            </div>
        </div>
    </x-card>
    <x-card class="mt-4 p-2 flex space-x-6">
        <a href="/materials/{{$material->id}}/edit"><i class="fa-solid fa-pencil"></i>edit</a>
    
            <form id="deleteForm" method="POST" action="/materials/{{$material->id}}">
                @csrf
                @method('DELETE')
                <button class="text-red-500" onclick="return confirmDelete()"><i class="fa-solid fa-trash"></i>Delete</button>
            </form>

            <script>
                function confirmDelete() {
                    // Display a confirmation dialog
                    var isConfirmed = confirm("Are you sure you want to delete this material?");

                    // If the user confirms, submit the form
                    if (isConfirmed) {
                        document.getElementById("deleteForm").submit();
                    }

                    // Return false to cancel the form submission if the user clicks "Annuler" (Cancel)
                    return false;
                }
            </script>
            
    </x-card>
</div>

@endsection