@extends('layout-manage')
@section('content')
@include('partials\_search')
<x-card class="p-10 rounded">
    <header>
        <h1
            class="text-3xl text-center font-bold my-6 uppercase"
        >
            Manage Materials
        </h1>
        <button id="viewButton" class="bg-blue-500 text-white px-4 py-2 rounded-md mb-10"><i id="eyeIcon"class="fa fa-eye"></i>
        View</button>
    </header>

    <div id="initialTable">
        <table class="w-full table-auto rounded-sm">
            <tbody>
                @unless($materials->isEmpty())
                @foreach($materials as $material)
                <tr class="border-gray-300" style="{{ $material->quantity < 10 ? 'background-color: #ef968f;' : '' }}">
                    <td
                        class="px-28 py-8 border-t border-b border-gray-300 text-lg"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->code}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                    >
                        <a
                            href="/materials/{{$material->id}}/edit"
                            class="text-blue-400 px-6 py-2 rounded-xl"
                            ><i
                                class="fa-solid fa-pen-to-square"
                            ></i>
                            Edit</a
                        >
                    </td>
                    <td class="px-4 py-2 border-t border-b border-gray-300">
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
                </td>
                </tr>
                @endforeach
                @else 
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <p class="text-center">No Materials Found</p>
                    </td>
                </tr>
                @endunless
            </tbody>
        </table>
    </div>
    <div id="expandedTable" class="hidden overflow-x-auto">
        <table class="w-full table-auto rounded-sm mt-12">
            <thead>
                <th class="px-4 py-2">Code</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Location</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Website</th>
                <th class="px-4 py-2">Brand</th>
                <th class="px-4 py-2">Category</th>
                <th class="px-4 py-2">Quantity</th>
                <th class="px-4 py-2">Used</th>
                <th class="px-4 py-2">Rate(DH)</th>
                <th class="px-4 py-2">State</th>
                <th class="px-4 py-2">Image</th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
            </thead>
            <tbody>
                @unless($materials->isEmpty())
                @foreach($materials as $material)
                <tr class="border-gray-300" style="{{ $material->quantity < 10 ? 'background-color: #ef968f;' : '' }}">
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->code}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->name}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->location}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->email}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->website}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            @php
                            $brands = DB::table('brands')
                                        ->select('id', 'name')
                                        ->where('active', 1)
                                        ->get();
    
                            foreach ($brands as $brand) {
                                if($brand->id==$material->brand){
                                    echo $brand->name;
                                }
                            }
                          @endphp
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            @php
                            $categories = DB::table('categories')
                                        ->select('id', 'name')
                                        ->where('active', 1)
                                        ->get();
    
                            foreach ($categories as $category) {
                                if($category->id==$material->category){
                                    echo $category->name;
                                }
                            }
                          @endphp
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->quantity}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->used_quantity}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            {{$material->rate}}
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            
                            @if($material->quantity > 0)
                                <!-- Button to open brand modal -->
                                <span class="text-green-500">
                                    Disponible
                                </span>
                            @else
                                <span class="text-red-500">Non Disponible</span>
                            @endif
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a href="/materials/{{$material->id}}">
                            <img
                                class="w-48 mr-6 mb-6"
                                src="{{$material->image ? asset('storage/' . $material->image) : asset('/images/no-image.png')}}"
                                alt=""
                            />
                        </a>
                    </td>
                    <td
                        class="px-4 py-2 border-t border-b border-gray-300"
                    >
                        <a
                            href="/materials/{{$material->id}}/edit"
                            class="text-blue-400 px-6 py-2 rounded-xl"
                            ><i
                                class="fa-solid fa-pen-to-square"
                            ></i>
                            Edit</a
                        >
                    </td>
                    <td class="px-4 py-2 border-t border-b border-gray-300">
                    <form id="deleteForm" method="POST" action="/materials/{{$material->id}}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500" onclick="return confirmDelete({{$material->id}})"><i class="fa-solid fa-trash"></i>Delete</button>
                    </form>

                    <script>
                        function confirmDelete(materialId) {
                            // Display a confirmation dialog
                            var isConfirmed = confirm("Are you sure you want to delete this material?");

                            // If the user confirms, submit the specific form based on materialId
                            if (isConfirmed) {
                                document.getElementById("deleteForm" + materialId).submit();
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
                        <p class="text-center">No Materials Found</p>
                    </td>
                </tr>
                @endunless
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const viewButton = document.getElementById("viewButton");
            const initialTable = document.getElementById("initialTable");
            const expandedTable = document.getElementById("expandedTable");

            let isExpanded = false;

            viewButton.addEventListener("click", function() {
                isExpanded = !isExpanded;

                if (isExpanded) {
                    viewButton.textContent = "Unview";
                    initialTable.style.display = "none";
                    expandedTable.style.display = "block";
                } else {
                    viewButton.innerHTML = `<i id="eyeIcon"class="fa fa-eye"></i> View`;
                    initialTable.style.display = "block";
                    expandedTable.style.display = "none";
                }
            });
        });
    </script>
</x-card>
@endsection