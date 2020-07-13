<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use App\Customers;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {

        $getInfo = Socialite::driver($provider)->user();

        $user = $this->createUser($getInfo,$provider);

        auth()->login($user);

        // return Socialite::with($provider)->redirect('customer-profile');

        return redirect()->to('/customer-profile');

    }

    function createUser($getInfo,$provider){

    $customers = Customers::where('provider_id', $getInfo->id)->first();

    if (!$customers) {
        $customers = new Customers;
        $customers->name = $getInfo->name;
        $customers->email = $getInfo->email;
        $customers->provider = $provider;
        $customers->provider_id = $getInfo->id;
        $customers->remember_token = $getInfo->token;
        $customers->save();
    }
    return $customers;
    }
}
