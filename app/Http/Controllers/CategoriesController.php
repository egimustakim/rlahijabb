<?php

namespace App\Http\Controllers;

use App\Categories;
use App\SubCategory;
use App\SubSubCategory;
use App\SubSubSubCategory;
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
        if($categories->save())
        return redirect('categories');
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
        $cateogry = SubCategory::findOrFail($request->idcat);
        $category = New SubCategory;
        $category->name = $request->inputName;
        $category->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $categories)
    {
        //
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
