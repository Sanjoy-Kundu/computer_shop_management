<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    function index(){
        $all_categories = Category::latest()->get();
        $trashed_categories = Category::onlyTrashed()->latest()->get();
        return view('Backend.Category.categorylist', compact('all_categories', 'trashed_categories'));
    }

    function add(){
        return view('Backend.Category.addCategory');
    }

    function insert(Request $request){


        $request->validate([
            'category_name' => 'required || max:30',
            'category_description' => 'required',
        ], [
            'category_name.required' =>'Name field is required',
            'category_name.max' => 'Name maximum 30 characters',
            'category_description.required' => "Description field is required",
        ]);

        $category_slug = Str::of($request->category_name)->slug('-');
        Category::insert($request->except('_token') + [
            'slug' =>$category_slug,
            'created_at' => Carbon::now()
        ]);
        return back()->withAlert_message('Category Inserted Successfully');
    }



    function editPage($category_id){
        $find_info = Category::find($category_id);
        return view('Backend.Category.categoryEdit', compact('find_info'));
    }


    function update(Request $request, $category_id){
       Category::find($category_id)->update([
        'category_name' => $request->category_name,
        'category_description' => $request->category_description
       ]);
       return redirect('category/list');
    }


    function delete($category_id){
        Category::find($category_id)->delete();
        return back()->withDelete_message('Category Deleted Successfully');
    }


}
