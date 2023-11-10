<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    //

    public function create(){
        return view('/manage/orders/add',['materials' => Material::latest()->
        filter(request(['tag','search']))->paginate()]);
    }

    public function store(StoreOrderRequest $request)
    {
        $orderData = $request->only(['client_name', 'client_contact','state','date']);
        
        $materials = $request->input('materials', []);
        $quantities = $request->input('quantities', []);
        $s=1;
        foreach ($materials as $key => $materialId) {
            $quantity = intval($quantities[$key]); // Convert to integer
            $material = Material::find($materialId);
    
            if ($material && $quantity > 0) {
                // Check if material exists and quantity is valid
                $newQuantity = $material->quantity - $quantity;
                // Check if the new quantity is non-negative
                if ($newQuantity <= 0) {
                    return redirect('http://127.0.0.1:8000/manage/orders/add')->with('message', 'Error: Material quantity cannot be negative.');
                    $s=0;
                }
            }
        }

        if($s==1){
            $order = Order::create($orderData);
        }
            
        
        for ($material=0; $material < count($materials); $material++) {
            if ($materials[$material] != '') {
                $order->materials()->attach($materials[$material], ['quantity' => $quantities[$material]]);
            }
        }

        // Loop through selected materials and quantities
        // Update quantities of materials
        
        if($order->state == 2){
            foreach ($materials as $key => $materialId) {
                $quantity = intval($quantities[$key]); // Convert to integer
                $material = Material::find($materialId);
        
                if ($material && $quantity > 0) {
                    // Check if material exists and quantity is valid
                    $newQuantity = $material->quantity - $quantity;
                    // Check if the new quantity is non-negative
                    if ($newQuantity > 0) {
                        $material->quantity = $newQuantity;
                        $material->used_quantity += $quantity;
                        $material->save();
                    }
                }
            }
        }
        

        return redirect('http://127.0.0.1:8000/manage/orders/manage')->with('message', 'Order created successfully!');
    }
    
    //Manage Orders
    public function manage(Request $request){
        // $userCategories = auth()->user()->categories()->get();
        DB::table('orders')->update(['date' => DB::raw('created_at')]);

        $query = Order::with('materials'); // Eager load materials relationship

        // Apply filters to the query
        if ($request->has('tag')) {
            $query->where('tag', $request->input('tag'));
        }

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('client_name', 'like', "%$searchTerm%")
                ->orWhere('client_contact', 'like', "%$searchTerm%")
                ->orWhere('state', 'like', "%$searchTerm%")
                ->orWhere('id', 'like', "%$searchTerm%")
                ->orWhere('date', 'like', "%$searchTerm%");
                
            });
        }
        
            // Filtre par chaque attribut (ajoutez autant de conditions que nécessaire)
            if ($request->filled('state')) {
                $query->where('state', $request->input('state'));
            }
        // Get paginated results
        // $orders = $query->latest()->paginate();

        $orders = $query->paginate();

        return view('manage.orders.manage', compact('orders'));
    }

    public function edit(Order $order){
        // dd($material->toArray());
         // Check if the order is in a completed state
         if ($order->state == 2) {
            return redirect('http://127.0.0.1:8000/manage/orders/manage')->with('error', 'Cannot edit a completed order.');
        }
        return view('/manage/orders/edit',['order'=>$order, 'materials' => Material::latest()->
        filter(request(['tag','search']))->paginate()]);
    }

    // public function update(UpdateOrderRequest $request, Order $order){
   
    //     // $formFields = $request->validate([
    //     //     'client_name' => 'required',
    //     //     'client_contact' => 'required',
    //     // ]);


    //     // $order->update($formFields);
    //     $orderData = $request->only(['client_name', 'client_contact']);
    //     $order->update($orderData);

    //     $order->materials()->detach();
    //     $materials = $request->input('materials', []);
    //     $quantities = $request->input('quantities', []);
        
    //     for ($material=0; $material < count($materials); $material++) {
    //         if ($materials[$material] != '') {
    //             $order->materials()->attach($materials[$material], ['quantity' => $quantities[$material]]);
    //         }
    //     }

    //     // Loop through selected materials and quantities
    //     // Update quantities of materials
        

    //     return redirect('../')->with('message','Order
    //     updated successfully!');
    // }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        // Get the original state before the update
        $originalState = $order->state;
        
        // Update the order details
        $orderData = $request->only(['client_name', 'client_contact', 'state','date']);
        $order->update($orderData);
    
        // Get the old quantities associated with the order
        $oldQuantities = $order->materials->pluck('pivot.quantity', 'id')->toArray();
    
        $order->materials()->detach();
        $materials = $request->input('materials', []);
        $newQuantities = $request->input('quantities', []);
    
        for ($material = 0; $material < count($materials); $material++) {
            if ($materials[$material] != '') {
                $order->materials()->attach($materials[$material], ['quantity' => $newQuantities[$material]]);
            }
        }
        
        // Check if the order state was pending and now it's completed
        if ($originalState == 1 && $order->state == 2) {
            // Update the materials associated with the order
            foreach ($materials as $key => $materialId) {
                $newQuantity = $newQuantities[$key];
                // Decrease the material quantity
                $material = Material::find($materialId);
                $material->quantity -= $newQuantity;
                $material->used_quantity += $newQuantity;
                $material->save();
            }

        }
    
        return redirect('http://127.0.0.1:8000/manage/orders/manage')->with('message', 'Order updated successfully!');
    }
    



    //Delete Order
    public function destroy(Order $order){
        // Make sure logged in user is owner
        $order->delete();
        return redirect('http://127.0.0.1:8000/manage/orders/manage')->with('message','Order deleted successfully');
    }

    //store Create Form
    // public function store(Request $request){
    //     $formFields = $request->validate([
    //         'order_date' => 'required',
    //         'client_name' => 'required',
    //         'client_contact' => 'required',
    //         'sub_total' => 'numeric',
    //         'vat' => 'numeric',
    //         'total_amount' => 'numeric',
    //         'discount' => 'required|numeric',
    //         'grand_total' => 'numeric',
    //         'paid_amount' => 'required|numeric',
    //         'due_amount' => 'numeric',
    //         'payment_type' => 'required',
    //         'payment_state' => 'required'
    //     ]);

    //     if($request->hasFile('image')){
    //         $formFields['image']=$request->file('image')->store('images',
    //     'public');
    //     }

    //     $formFields['user_id'] = auth()->id();

    //     Order::create($formFields);

    //     return redirect('../')->with('message','Order 
    //     created successfully!');
    // }
}
