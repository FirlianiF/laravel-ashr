<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('home');
});
Auth::routes([
    'register'=>false
]);
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>'admin','prefix'=>'admin'], function(){
    Route::get('get/companies', 'CompaniesController@get_companies')->name('get.companies');

    // API search companies with param ?email={email}&name={company name}&website={website}
    Route::get('get/companies/search', 'CompaniesController@get_companies_search');
    // API detailed company with param ID
    Route::get('get/companies/detail/{id}', 'CompaniesController@get_companies_detail');


    Route::get('get/employees', 'EmployeesController@get_employees')->name('get.employees');

    // API search employees with param ?email={email}&first_name={first name}&last_name={last name}&company={company}
    Route::get('get/employees/search', 'EmployeesController@get_employees_search');
    // API detailed employee with param ID
    Route::get('get/employees/detail/{id}', 'EmployeesController@get_employees_detail');

    Route::resource('/companies', 'CompaniesController');
    Route::resource('/employees', 'EmployeesController');
});
