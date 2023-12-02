<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    //show Create Form
    public function create(){
        return view('categories.create');
    }

    //store Create Form
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required',Rule::unique('categories','name')],
        ]);

        // if($request->hasFile('image')){
        //     $formFields['image']=$request->file('image')->store('images',
        // 'public');
        // }

        $formFields['user_id'] = auth()->id();


        $formFields['state'] = 0;


        Category::create($formFields);


        return redirect('http://127.0.0.1:8000/manage/category')->with('message','Category 
        created successfully!');
    }

    public function edit(Category $category){
        return view('categories.edit',['category' => $category]);
    }

    public function update(Request $request, Category $category){
        
        // Make sure logged in user is owner
        if($category->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }

        $formFields = $request->validate([
            'name' => 'required',
        ]);

        

        $category->update($formFields);



        return redirect('http://127.0.0.1:8000/manage/category')->with('message','Category 
        updated successfully!');
    }

    //Delete Category
    public function destroy(Category $category){
        // Make sure logged in user is owner
        if($category->user_id != auth()->id()){
            abort(403,'Unauthorized action');
        }
        $category->delete();
        return redirect('http://127.0.0.1:8000/manage/category')->with('message','Category deleted successfully');
    }

    //Manage Categories
    public function manage(){
        // $userCategories = auth()->user()->categories()->get();
        $categories = Category::latest()->filter(request(['tag', 'search']))->paginate();

        foreach ($categories as $category) {
            // Check if the category has associated materials
            $hasMaterials = $category->materials()->exists();

            // Update the state based on the presence of associated materials
            $category->update([
                'state' => $hasMaterials ? 1 : 0,
            ]);
        }
        return view('manage.category',['categories' => Category::latest()->
        filter(request(['tag','search']))->paginate()]);
    }
}
