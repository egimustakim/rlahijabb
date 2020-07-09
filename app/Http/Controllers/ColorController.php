<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Colors;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Colors::all();
        return view('admin/color', compact('colors'));
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
        $count = Colors::where('name', '=' ,$request->colorname)->first();
        if($count)
        {
            $request->session()->flash('alert-info', 'Color data exist');
            return back();
        }
        $color = New Colors;
        $color->name = $request->colorname;
        if ($color->save())
        {
            $request->session()->flash('alert-success', 'Color was successful added!');
            return back();
        }
        else
        {
            $request->session()->flash('alert-info', 'Color was failed added!');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $count = Colors::where('name', '=' ,$request->colorname)->first();
        if($count)
        {
            $request->session()->flash('alert-info', 'Color data exist');
            return back();
        }
        $color = Colors::findOrFail($request->colorid);
        $color->name = $request->colorname;
        if($color->update())
        {
            $request->session()->flash('alert-success', 'Color update success!');
            return back();
        }
        else
        {
            $request->session()->flash('alert-info', 'Color update failed');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $color = Colors::findOrFail($request->colorid);
        if($color->delete())
        {
            $request->session()->flash('alert-success', 'Delete data success!');
            return back();
        }
        else
        {
            $request->session()->flash('alert-info', 'Delete data failed');
            return back();
        }
    }
}
