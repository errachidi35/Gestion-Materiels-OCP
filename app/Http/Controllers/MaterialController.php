<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class MaterialController extends Controller
{
    //show all materials
    public function index(Request $request){
        return view('materials.index',[
            'materials' => Material::latest()->
            filter(request(['tag','search']))->paginate(6)
        ]);
    }

    //show single material
    public function show(Material $material){
        $material->load('brand');
        $material->load('category');
        return view('materials.show', [
            'material' => $material
        ]);
    }

    //show Create Form
    public function create(){
        return view('materials.create');
    }

    //store Create Form
    public function store(Request $request){
        $formFields = $request->validate([
            'code' => ['required', Rule::unique('materials',
            'code')],
            'name' => 'required',
            'location' => 'required',
            'email' => ['required','email'],
            'website' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'quantity' => 'required|integer',
            'rate' => 'required|numeric',
            'description' => 'required'
        ]);

        $formFields['state'] = ($request->input('quantity') > 0) ? 1 : 0;

        if($request->hasFile('image')){
            $formFields['image']=$request->file('image')->store('images',
        'public');
        }

        $formFields['user_id'] = auth()->id();

        Material::create($formFields);


        return redirect('/')->with('message','Material 
        created successfully!');
    }

    public function edit(Material $material){
        $material->load('brand');
        $material->load('category');
        // dd($material->toArray());
        return view('materials.edit',['material' => $material]);
    }

    public function update(Request $request, Material $material){
        
        // Make sure logged in user is owner
        if($material->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }

        $formFields = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'location' => 'required',
            'email' => ['required','email'],
            'website' => 'required',
            'brand' => 'required',
            'category' => 'required',
            'quantity' => 'required|integer',
            'rate' => 'required|numeric',
            'description' => 'required'
        ]);

        $formFields['state'] = ($request->input('quantity') > 0) ? 1 : 0;


        if($request->hasFile('image')){
            $formFields['image']=$request->file('image')->store('images',
        'public');
        }

        $material->update($formFields);


        return redirect('/materials/' . $material->id)->with('message','Material 
        updated successfully!');
    }

    //Delete Material
    public function destroy(Material $material){
        // Make sure logged in user is owner
        if($material->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }
        $material->delete();
        return redirect('http://127.0.0.1:8000/manage/material')->with('message','Material deleted successfully');
    }

    //Manage Materials
    public function manage(){
        // $userMaterials = auth()->user()->materials()->get();
        return view('manage.material',['materials' => Material::latest()->
        filter(request(['tag','search']))->paginate()]);
        // return view('materials.index',[
        //     'materials' => Material::latest()->
        //     filter(request(['tag','search']))->paginate(6)
        // ]);
    }


}

