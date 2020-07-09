<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Provinces;
use App\Regencies;
use App\Districts;
use App\Villages;

class CountryController extends Controller
{
    public function provinces()
    {
        $provinces = Provinces::all();
        return view('admin/province', compact('provinces'));
    }

    public function districts()
    {
        $districts = Districts::all();
        return view('admin/district', compact('districts'));
    }

    public function regencies()
    {
        $regencies = Regencies::all();
        return view('admin/regencie', compact('regencies'));
    }

    public function villages()
    {
        $villages = Villages::paginate(100);
        return view('admin/village', compact('villages'));
    }

    public function regenciesjson()
    {
        $provinces_id = Input::get('province_id');
        $regencies = Regencies::where('province_id', '=', $provinces_id)->get();
        return response()->json($regencies);
    }

    public function districtsjson()
    {
        $regency_id = Input::get('regency_id');
        $districts = Districts::where('regency_id', '=', $regency_id)->get();
        return response()->json($districts);
    }

    public function villagesjson()
    {
        $districts_id = Input::get('districts_id');
        $villages = Villages::where('district_id', '=', $districts_id)->get();
        return response()->json($villages);
    }
}
