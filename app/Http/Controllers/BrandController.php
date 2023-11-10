<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{

    //show Create Form
    public function create(){
        return view('brands.create');
    }

    //store Create Form
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required',Rule::unique('brands','name')],
            'state' => 'integer',
        ]);

        if($request->hasFile('image')){
            $formFields['image']=$request->file('image')->store('images',
        'public');
        }

        $formFields['user_id'] = auth()->id();

        $formFields['state'] = 0;


        Brand::create($formFields);


        return redirect('http://127.0.0.1:8000/manage/brand')->with('message','Brand 
        created successfully!');
    }

    public function edit(Brand $brand){
        return view('brands.edit',['brand' => $brand]);
    }

    public function update(Request $request, Brand $brand){
        
        // Make sure logged in user is owner
        if($brand->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }

        $formFields = $request->validate([
            'name' => 'required',
            'state' => 'integer',
        ]);

        

        $brand->update($formFields);



        return redirect('http://127.0.0.1:8000/manage/brand')->with('message','Brand 
        updated successfully!');
    }

    //Delete Brand
    public function destroy(Brand $brand){
        // Make sure logged in user is owner
        if($brand->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }
        $brand->delete();
        return redirect('http://127.0.0.1:8000/manage/brand')->with('message','Brand deleted successfully');
    }

    //Manage Brands
    public function manage(){
        // $userBrands = auth()->user()->brands()->get();
        $brands = Brand::latest()->filter(request(['tag', 'search']))->paginate();

        foreach ($brands as $brand) {
            // Check if the brand has associated materials
            $hasMaterials = $brand->materials()->exists();

            // Update the state based on the presence of associated materials
            $brand->update([
                'state' => $hasMaterials ? 1 : 0,
            ]);
        }
        return view('manage.brand',['brands' => Brand::latest()->
        filter(request(['tag','search']))->paginate()]);
    }
}
