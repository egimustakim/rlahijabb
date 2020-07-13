<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//front-end

Route::get('/', function () {
    return view('home');
});

Route::get('customer-login', function () {
    return view('customer-login');
});

Route::get('customer-profile', function () {
    return view('customer-profile');
});

Route::get('/auth/redirect/{provider}', 'SocialController@redirect');

Route::get('/callback/{provider}', 'SocialController@callback');

//back-end

Auth::routes([
    'register' => false,
]);

Route::get('rlaadmin', 'RlaadminController@index')->name('rlaadmin');

Route::group(['middleware' => 'auth'], function () {

    Route::resource('colors', 'ColorController');

    Route::resource('brands', 'BrandsController');

    Route::resource('colors', 'ColorController');

    Route::resource('materials', 'MaterialsController');

    Route::get('provinces', 'CountryController@provinces');

    Route::get('districts', 'CountryController@districts');

    Route::get('regencies', 'CountryController@regencies');

    Route::get('villages', 'CountryController@villages');

    Route::get('json-regencies', 'CountryController@regenciesjson');

    Route::get('json-districts', 'CountryController@districtsjson');

    Route::get('json-villages', 'CountryController@villagesjson');

    Route::get('shipping', 'ShippingController@index');

    Route::post('shipping/addprovider', 'ShippingController@addprovider');

    Route::resource('categories', 'CategoriesController');

});

// Route::get('/home', 'HomeController@index')->name('home');
