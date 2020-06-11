<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    /*Route::get('/customers', 'CustomersController@index');
    Route::get('/customers/create', 'CustomersController@create');
    Route::get('/customers/{customer}', 'CustomersController@show');
    Route::get('/customers/{customer}/edit', 'CustomersController@edit');
    Route::patch('/customers/{customer}', 'CustomersController@update');
    Route::post('/customers', 'CustomersController@store');
    Route::delete('/customers/{customer}', 'CustomersController@destroy');*/

    Route::resource('/customers', 'CustomersController');

    Route::get('/customers/{customer}/addresses', 'CustomerAddressesController@index');
    Route::get('/customers/{customer}/addresses/create', 'CustomerAddressesController@create');
    Route::get('/customers/{customer}/addresses/{address}/edit', 'CustomerAddressesController@edit');
    Route::patch('/customers/{customer}/addresses/{address}', 'CustomerAddressesController@update');
    Route::post('/customers/{customer}/addresses', 'CustomerAddressesController@store');
    Route::delete('/customers/{customer}/addresses/{address}', 'CustomerAddressesController@destroy');

    Route::get('/home', 'HomeController@index')->name('home');
});

Route::get('/customers/{customer}/invoices', 'InvoicesController@index');
Route::get('/customers/{customer}/invoices/create', 'InvoicesController@create');
Route::get('/customers/{customer}/invoices/{invoice}', 'InvoicesController@show');
Route::post('/customers/{customer}/invoices', 'InvoicesController@store');

Route::get('/customers/{customer}/invoices/{invoice}/download', 'PDFController@create');

Auth::routes();


