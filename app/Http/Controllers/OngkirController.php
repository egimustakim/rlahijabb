<?php

namespace App\Http\Controllers;

use App\Shipping;
use Illuminate\Http\Request;

class OngkirController extends Controller
{
    public function index() {
        return view('admin/ongkir');
    }
}
