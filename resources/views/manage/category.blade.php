@extends('layout-manage')
@section('content')
@include('partials\_search')
<x-card class="p-10 rounded">
    <header>
        <h1
            class="text-3xl text-center font-bold my-6 uppercase"
        >
            Manage Categories
        </h1>
        <div
            class="px-4 py-8 border-t border-b border-gray-300 text-lg"
        >
            <a
                href="/categories/create"
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
            @unless($categories->isEmpty())
            @foreach($categories as $category)
            <tr class="border-gray-300">
                <td
                    class="px-28 py-8 border-t border-b border-gray-300 text-lg"
                >
                  
                        {{$category->name}}
                    
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    @if($category->state == 1)
                        <!-- Button to open category modal -->
                        <button class="text-green-500" 
                                data-material-count="{{$category->materials->count()}}" 
                                data-used-number="{{$category->materials->sum('used_number')}}">
                            Disponible
                        </button>
                    @else
                        <span class="text-red-500">Non Disponible</span>
                    @endif
                </td>

                <!-- Modal for displaying category details -->
                <div id="categoryModal" class="fixed top-0 left-0 w-full h-full bg-white bg-opacity-90 flex justify-center items-center hidden">
                    <div class="w-1/2 p-6 bg-white rounded-lg">
                        <h2 class="text-2xl font-bold mb-4">Category Information</h2>
                        <p id="categoryInfo1"></p>
                        <p id="categoryInfo2"></p>
                        <button id="closecategoryModal" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md">Close</button>
                    </div>
                </div>

                <script>
                // JavaScript for displaying category details in a modal
                document.addEventListener("click", function (event) {
                    if (event.target.classList.contains("text-green-500")) {
                        event.preventDefault();
                        const categoryInfo1 = document.getElementById("categoryInfo1");
                        categoryInfo1.textContent = `Number of Materials: {{$category->materials->count()}}`;
                        const categoryInfo2 = document.getElementById("categoryInfo2");
                        categoryInfo2.textContent = `Used Number: {{$category->materials->sum('used_number')}}`;
                    
                        document.getElementById("categoryModal").classList.remove("hidden");
                    }

                    if (event.target.id === "closecategoryModal") {
                        document.getElementById("categoryModal").classList.add("hidden");
                    }
                });
                </script>


                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a
                        href="/categories/{{$category->id}}/edit"
                        class="text-blue-400 px-6 py-2 rounded-xl"
                        ><i
                            class="fa-solid fa-pen-to-square"
                        ></i>
                        Edit</a
                    >
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form id="deleteForm" method="POST" action="/categories/{{$category->id}}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500" onclick="return confirmDelete({{$category->id}})"><i class="fa-solid fa-trash"></i>Delete</button>
                    </form>

                    <script>
                        function confirmDelete(categoryId) {
                            // Display a confirmation dialog
                            var isConfirmed = confirm("Are you sure you want to delete this category?");

                            if (isConfirmed) {
                                document.getElementById("deleteForm" + categoryId).submit();
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
                    <p class="text-center">No Categories Found</p>
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-card>
@endsection