@extends('layout-manage')
@section('content')
    <x-card class="p-10 rounded max-w-[60rem] mx-auto mt-24"
    >
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Add order
            </h2>
            <br>
        </header>

        <form method="POST" action="/manage/orders" enctype="multipart/form-data">
            @csrf
            <!-- <div class="mb-6">
                <label
                    for="order_date"
                    class="inline-block text-lg mb-2"
                    > Order date</label
                >
                <input
                    type="date"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="order_date"
                    value="{{old('order_date')}}"
                />

                @error('order_date')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div> -->

            <div class="mb-6">
                <label for="client_name" class="inline-block text-lg mb-2">
                    Client name
                </label>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="client_name"
                    value="{{old('client_name')}}"
                />

                @error('client_name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror            
            </div>

            <div class="mb-6">
                <label for="client_contact" class="inline-block text-lg mb-2">
                    Client contact
                </label>
                <input
                    type="tel"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="client_contact"
                    value="{{old('client_contact')}}"
                />

                @error('client_contact')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror            
            </div>

            <div class="inline-block text-lg mb-2">Materials</div>
            
            <table id="materials_table">
                <thead>
                    <tr>
                        <th class="p-2">Material</th>
                        <th class="p-2">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="material0" >
                    <td class="p-2">
                        <select name="materials[]" class="w-80 p-2 border rounded material-select select2">
                            <option value="">-- Choose material --</option>
                            @foreach ($materials as $material)
                                @if ($material->state == 1 && $material->quantity > 0)
                                    <option value="{{ $material->id }}" data-available-quantity="{{ $material->quantity }}">
                                        {{ $material->name }} (${{ number_format($material->rate, 2) }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                <td class="p-2">
                    <input type="number" name="quantities[]" class="p-2 border rounded quantity-input" value="1" required min="1" />
                </td>
                <td class="p-2">
                    <button class="bg-red-500 text-white p-2 rounded-md delete-row">- Delete Row</button>
                </td>
                    </tr>
                    <!-- <tr id="material1" ></tr> -->
                </tbody>
            </table>

            <div class="flex">
                <button id="add_row" class="bg-blue-500 text-white p-2 rounded-md ml-auto">+ Add Row</button>
            </div>
        

            <div class="mb-6">
                <label for="state" class="inline-block text-lg mb-2">
                    State
                </label>
                <select class="border border-gray-200 rounded p-2 w-full" id="state" name="state">
                      <option value="0">~~SELECT~~</option>
                      <option value="1">Pending</option>
                      <option value="2">Completed</option>          
                </select>  
                @error('state')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror              
            </div>
                

            <div class="mb-6 mt-12">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Create Order
                </button>

                <a href="../" class="text-black ml-4"> Back </a>
            </div>
        </form>
        <script>
        // $(document).ready(function(){
        //     let row_number = {{ count(old('materials', [''])) }};
        //     $("#add_row").click(function(e){
        //     e.preventDefault();
        //     let new_row_number = row_number - 1;
        //     $('#material' + row_number).html($('#material' + new_row_number).html()).find('td:first-child');
        //     $('#materials_table').append('<tr id="material' + (row_number + 1) + '"></tr>');
        //     row_number++;
        //     });

        //     $("#delete_row").click(function(e){
        //     e.preventDefault();
        //     if(row_number > 1){
        //         $("#material" + (row_number - 1)).html('');
        //         row_number--;
        //     }
        //     });
        // });
        $(document).ready(function(){
            $('#material0').find('.select2').select2();

            let row_number = {{ count(old('materials', [''])) }};
            $("#add_row").click(function (e) {
            e.preventDefault();

            // Create a new <tr> element
            let newDropdownRow = '<tr id="material' + row_number + '">' +
                '<td class="p-2">' +
                '<select name="materials[]" class="w-80 p-2 border rounded material-select select2">' +
                '<option value="">-- Choose material --</option>' +
                '@foreach ($materials as $material)' +
                '@if ($material->state == 1 && $material->quantity > 0)' +
                '<option value="{{ $material->id }}" data-available-quantity="{{ $material->quantity }}">' +
                '{{ $material->name }} (${{ number_format($material->rate, 2) }})' +
                '</option>' +
                '@endif' +
                '@endforeach' +
                '</select>' +
                '</td>' +
                '<td class="p-2">' +
                '<input type="number" name="quantities[]" class="p-2 border rounded quantity-input" value="1" required min="1" />' +
                '</td>' +
                '<td class="p-2">' +
                '<button class="bg-red-500 text-white p-2 rounded-md delete-row">- Delete Row</button>' +
                '</td>' +
                '</tr>';

            // Append the new row to the table
            $('#materials_table').append(newDropdownRow);

            // Reinitialize Select2 for the new row
            $('#material' + row_number).find('.select2').select2();
            row_number++;
        });

        $('#materials_table').on('click', '.delete-row', function (e) {
        e.preventDefault();

        if ($('#materials_table tr').length-1 > 1) {
            // Find the closest 'tr' (row) and remove it
            $(this).closest('tr').remove();
        } else {
            // Optionally, you can add an alert or message to indicate that the last row cannot be deleted
            alert("You cannot delete the last row.");
        }

    });




    
});
        </script>
    </x-card>
@endsection
