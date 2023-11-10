@extends('layout-manage')
@section('content')
@include('partials\_search')

@php
$totalQuantity = 0;
$totalPrice = 0;
@endphp

<x-card class="p-10 rounded">
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">Manage Orders</h1>
    </header>
    <form action="/manage/orders/manage" method="GET">
        <label for="state">Filter by State:</label>
        <select name="state" id="state">
            <option value="">All</option>
            <option value="1" {{ request('state') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="2" {{ request('state') == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
        <button type="submit">Apply Filter</button>
    </form>
    <div id="expandedTable" class="overflow-x-auto">
        <table class="w-full table-auto rounded-sm mt-12" style="table-layout: fixed; width: 100%;">
            <thead>
                <th style="width: 10%;">ID</th>
                <th style="width: 15%;">Order Date</th>
                <th style="width: 15%;">Client Name</th>
                <th style="width: 15%;">Client Contact</th>
                <th style="width: 20%;">Action</th>
                <th style="width: 10%;">Quantity</th>
                <th style="width: 10%;">Price</th>
                <th style="width: 10%;">State</th>
                <th style="width: 10%;">Edit</th>
                <th style="width: 10%;">Delete</th>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @php
                    $orderQuantity = 0;
                    $orderPrice = 0;
                    @endphp

                    <tr class="border-gray-300" data-entry-id="{{ $order->id }}">
                        <td class="pl-[10px] text-center border-t border-b border-gray-300">{{ $order->id ?? '' }}</td>
                        <td class="pl-[15px] text-center border-t border-b border-gray-300">
                            @if ($order->date)
                                {{ $order->date}}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="pl-[15px] text-center border-t border-b border-gray-300">{{ $order->client_name ?? '' }}</td>
                        <td class="pl-[15px] text-center border-t border-b border-gray-300">{{ $order->client_contact ?? '' }}</td>
                        <td class="pl-[20px] text-center border-t border-b border-gray-300">
                            @foreach($order->materials as $item)
                                    @php
                                    $quantity = $item->pivot->quantity;
                                    $rate = $item->rate;
                                    $subtotal = $quantity * $rate;
                                    $orderQuantity += $quantity;
                                    $orderPrice += $subtotal;
                                    $totalQuantity += $quantity;
                                    $totalPrice += $subtotal;
                                    @endphp
                                @endforeach
                            <button class="text-blue-600 view-products" data-order="{{ json_encode($order->materials) }}">View Products</button>
                        </td>
                        <td class="text-center border-t border-b border-gray-300">{{ $orderQuantity }}</td>
                        <td class="text-center border-t border-b border-gray-300">${{ $orderPrice }}</td>
                        <td class="text-center border-t border-b border-gray-300">
                            <p href="/orders/{{$order->id}}" style="color: {{ $order->state == 2 ? 'green' : 'inherit' }}">
                                @php
                                    if($order->state == 1 || $order->state == 0){
                                        echo "Pending";
                                    } else {
                                        echo "Completed";
                                    }
                                @endphp
                            </p>
                        </td>
                        <td class="text-center border-t border-b border-gray-300">
                            <a href="/manage/orders/{{$order->id}}/edit" class="text-blue-600">Edit</a>
                        </td>
                        
                        <td class="text-center px-4 py-2 border-t border-b border-gray-300">
                       <form id="deleteForm" method="POST" action="/manage/orders/{{$order->id}}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500" onclick="return confirmDelete({{$order->id}})"><i class="fa-solid fa-trash"></i>Delete</button>
                        </form>

                        <script>
                            function confirmDelete(orderId) {
                                // Display a confirmation dialog
                                var isConfirmed = confirm("Are you sure you want to delete this order?");

                                if (isConfirmed) {
                                    document.getElementById("deleteForm" + orderId).submit();
                                }

                                // Return false to cancel the form submission if the user clicks "Annuler" (Cancel)
                                return false;
                            }
                        </script>
                </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Display total quantity and total price outside of the loop -->
    <div class="mt-4">
        <strong>Total Quantity: {{ $totalQuantity }}</strong>
        <br>
        <strong>Total Price: ${{ $totalPrice }}</strong>
    </div>
</x-card>

<!-- Modal for displaying product details -->
<div id="productModal" class="fixed top-0 left-0 w-full h-full bg-white bg-opacity-90 flex justify-center items-center hidden">
    <div class="w-1/2 p-6 bg-white rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Products</h2>
        <ul id="productList">
            <!-- Product details will be inserted here -->
        </ul>
        <button id="closeProductModal" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md">Close</button>
    </div>
</div>

<script>
// JavaScript for displaying product details in a modal
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("view-products")) {
        event.preventDefault();
        const orderData = JSON.parse(event.target.getAttribute("data-order"));
        const productList = document.getElementById("productList");
        productList.innerHTML = "";
        orderData.forEach(item => {
            const listItem = document.createElement("li");
            listItem.textContent = `${item.name} (${item.pivot.quantity} x $${item.rate}) = $${item.pivot.quantity * item.rate}`;
            productList.appendChild(listItem);
        });
        document.getElementById("productModal").classList.remove("hidden");
    }

    if (event.target.id === "closeProductModal") {
        document.getElementById("productModal").classList.add("hidden");
    }
});
</script>
@endsection

