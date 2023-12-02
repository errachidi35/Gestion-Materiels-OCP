@extends('layout-manage')
@section('content')
@include('partials\_search')
<x-card class="p-10 rounded">
    <header>
        <h1
            class="text-3xl text-center font-bold my-6 uppercase"
        >
            Manage Brands
        </h1>
        <div
            class="px-4 py-8 border-t border-b border-gray-300 text-lg"
        >
            <a
                href="/brands/create"
                class="text-blue-400 px-6 py-2 rounded-xl"
                ><i
                    class="fa-solid fa-plus"
                ></i>
                Add</a
            >
        </div>
    </header>

    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($brands->isEmpty())
            @foreach($brands as $brand)
            <tr class="border-gray-300">
                <td
                    class="px-28 py-8 border-t border-b border-gray-300 text-lg"
                >
                  
                        {{$brand->name}}
                    
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    @if($brand->state==1)
                        <!-- Button to open brand modal -->
                        <button class="text-green-500" 
                                data-material-count="{{$brand->materials->count()}}" 
                                data-used-number="{{$brand->materials->sum('used_number')}}">
                            Disponible
                        </button>
                    @else
                        <span class="text-red-500">Non Disponible</span>
                    @endif
                </td>

                <!-- Modal for displaying brand details -->
                <div id="brandModal" class="fixed top-0 left-0 w-full h-full bg-white bg-opacity-90 flex justify-center items-center hidden">
                    <div class="w-1/2 p-6 bg-white rounded-lg">
                        <h2 class="text-2xl font-bold mb-4">Brand Information</h2>
                        <p id="brandInfo1"></p>
                        <p id="brandInfo2"></p>
                        <button id="closebrandModal" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md">Close</button>
                    </div>
                </div>

                <script>
                // JavaScript for displaying brand details in a modal
                document.addEventListener("click", function (event) {
                    if (event.target.classList.contains("text-green-500")) {
                        event.preventDefault();
                        const brandInfo1 = document.getElementById("brandInfo1");
                        brandInfo1.textContent = `Number of Materials: {{$brand->materials->count()}}`;
                        const brandInfo2 = document.getElementById("brandInfo2");
                        brandInfo2.textContent = `Used Number: {{$brand->materials->sum('used_number')}}`;
                    
                        document.getElementById("brandModal").classList.remove("hidden");
                    }

                    if (event.target.id === "closebrandModal") {
                        document.getElementById("brandModal").classList.add("hidden");
                    }
                });
                </script>
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a
                        href="/brands/{{$brand->id}}/edit"
                        class="text-blue-400 px-6 py-2 rounded-xl"
                        ><i
                            class="fa-solid fa-pen-to-square"
                        ></i>
                        Edit</a
                    >
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form id="deleteForm" method="POST" action="/brands/{{$brand->id}}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500" onclick="return confirmDelete({{$brand->id}})"><i class="fa-solid fa-trash"></i>Delete</button>
                    </form>

                    <script>
                        function confirmDelete(brandId) {
                            // Display a confirmation dialog
                            var isConfirmed = confirm("Are you sure you want to delete this brand?");

                            if (isConfirmed) {
                                document.getElementById("deleteForm" + brandId).submit();
                            }

                            // Return false to cancel the form submission if the user clicks "Annuler" (Cancel)
                            return false;
                        }
                    </script>
                </td>


            </tr>
            @endforeach
            @else 
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <p class="text-center">No Brands Found</p>
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-card>
@endsection