<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();
        return view('admin/categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = New Categories();
        $categories->name = $request->inputName;
        $categories->parent_id = $request->parentCat;
        $count = Categories::where('name', '=' ,$request->inputName)->where('parent_id', '=' ,$request->parentCat)->first();
        if ($count)
        {
            $request->session()->flash('alert-info', 'Category name is exist!');
            return redirect('categories');
        }
        if ($categories->save())
        {
            $request->session()->flash('alert-success', 'Category was successful added!');
            return redirect('categories');
        }
        else
        {
            $request->session()->flash('alert-info', 'Category was failed added!');
            return redirect('categories');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $categories = Categories::findOrFail($request->categoryId);
        $categories->name = $request->categoryName;
        if($categories->update())
        {
            $request->session()->flash('alert-success', 'Category was successful added!');
            return back();
        }
        else
        {
            $request->session()->flash('alert-info', 'Category was failed added!');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $categories = Categories::findOrFail($request->categoryId);
        if($categories->delete())
        {
            $request->session()->flash('alert-success', 'Category deleted!');
            return back();
        }
        else
        {
            $request->session()->flash('alert-info', 'Category delete failed!');
            return back();
        }
    }

    public function subcategoriesstore (Request $request)
    {
        $subcategories = New SubCategory();
        $categoryId = $request->opCategoryId;
        $subCatName = $request->inputSubName;
        if ($categoryId > 2)
        {
            $errormsg = "Category name isn't available";
            return redirect('categories?errormsg=1');
        }
        else if (SubCategory::where('name', 'LIKE', $subCatName)->where('categories_id', '=', $categoryId)->count() > 0)
        {
            $errormsg = "Category name exist";
            return redirect('categories?errormsg=2');
        }
        else
        {
            $subcategories->categories_id = $categoryId;
            $subcategories->name = $subCatName;
            $subcategories->save();
            return redirect('categories');
        }
    }
}
