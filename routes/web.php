<?php

use Illuminate\Support\Facades\Route;

// 管理
Route::prefix(env('APP_ADMIN_PATH', 'admin'))->group(function () {
    Route::get('/', 'App\Http\Controllers\Admin\IndexController@login')->name('adminRoot');
    Route::post('/login', 'App\Http\Controllers\Admin\IndexController@login')->name('adminLogin');
    Route::post('/logout', 'App\Http\Controllers\Admin\IndexController@logout')->name('adminLogout');
    Route::get('/dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('adminDashboard')->middleware('checkAuth:admin|none');

    Route::get('/login-log', 'App\Http\Controllers\Admin\LoginLogController@index')->middleware('checkAuth:admin|none');
    
    Route::get('/admin', 'App\Http\Controllers\Admin\AdminController@index')->name('adminList')->middleware('checkAuth:admin|none');
    Route::get('/admin/status/{admin_id}/{status}', 'App\Http\Controllers\Admin\AdminController@updateStatus')->name('adminUpdateStatus')->middleware('checkAuth:admin|none');
    Route::get('/admin/{admin_id}', 'App\Http\Controllers\Admin\AdminController@show')->name('admin')->middleware('checkAuth:admin|none');
    Route::get('/admin/edit/{admin_id}', 'App\Http\Controllers\Admin\AdminController@edit')->name('adminEdit')->middleware('checkAuth:admin|none');
    Route::post('/admin/{admin_id}', 'App\Http\Controllers\Admin\AdminController@save')->name('adminSave')->middleware('checkAuth:admin|none');

    Route::get('/hospital', 'App\Http\Controllers\Admin\HospitalController@index')->name('adminHospitalList')->middleware('checkAuth:admin|none');
    Route::get('/hospital/status/{hospital_id}/{status}', 'App\Http\Controllers\Admin\HospitalController@updateStatus')->name('adminUpdateHospitalStatus')->middleware('checkAuth:admin|none');
    Route::get('/hospital/{hospital_id}', 'App\Http\Controllers\Admin\HospitalController@show')->name('adminHospital')->middleware('checkAuth:admin|none');
    Route::get('/hospital/edit/{hospital_id}', 'App\Http\Controllers\Admin\HospitalController@edit')->name('adminEditHospital')->middleware('checkAuth:admin|none');
    Route::post('/hospital/{hospital_id}', 'App\Http\Controllers\Admin\HospitalController@save')->name('adminSaveHospital')->middleware('checkAuth:admin|none');

    Route::get('/user', 'App\Http\Controllers\Admin\UserController@index')->name('adminUserList')->middleware('checkAuth:admin|none');
    Route::get('/user/status/{user_id}/{status}', 'App\Http\Controllers\Admin\UserController@updateStatus')->name('adminUpdateUserStatus')->middleware('checkAuth:admin|none');
    Route::get('/user/{user_id}', 'App\Http\Controllers\Admin\UserController@show')->name('adminUser')->middleware('checkAuth:admin|none');
    Route::get('/user/edit/{user_id}', 'App\Http\Controllers\Admin\UserController@edit')->name('adminEditUser')->middleware('checkAuth:admin|none');
    Route::post('/user/{user_id}', 'App\Http\Controllers\Admin\UserController@save')->name('adminSaveUser')->middleware('checkAuth:admin|none');

    Route::get('/admin-authority', 'App\Http\Controllers\Admin\AdminAuthorityController@index')->name('adminAuthorityList')->middleware('checkAuth:admin|admin-authority');
    Route::get('/admin-authority/status/{admin_authority_id}/{status}', 'App\Http\Controllers\Admin\AdminAuthorityController@updateStatus')->name('adminUpdateAuthorityStatus')->middleware('checkAuth:admin|admin-authority');
    Route::get('/admin-authority/{admin_authority_id}', 'App\Http\Controllers\Admin\AdminAuthorityController@show')->name('adminAuthority')->middleware('checkAuth:admin|admin-authority');
    Route::get('/admin-authority/edit/{admin_authority_id}', 'App\Http\Controllers\Admin\AdminAuthorityController@edit')->name('adminEditAuthority')->middleware('checkAuth:admin|admin-authority');
    Route::post('/admin-authority/{admin_authority_id}', 'App\Http\Controllers\Admin\AdminAuthorityController@save')->name('adminSaveAuthority')->middleware('checkAuth:admin|admin-authority');
    
    Route::get('/hospital-authority', 'App\Http\Controllers\Admin\HospitalAuthorityController@index')->name('adminHospitalAuthorityList')->middleware('checkAuth:admin|hospital-authority');
    Route::get('/hospital-authority/status/{hospital_authority_id}/{status}', 'App\Http\Controllers\Admin\HospitalAuthorityController@updateStatus')->name('adminUpdateHospitalAuthorityStatus')->middleware('checkAuth:admin|hospital-authority');
    Route::get('/hospital-authority/{hospital_authority_id}', 'App\Http\Controllers\Admin\HospitalAuthorityController@show')->name('adminHospitalAuthority')->middleware('checkAuth:admin|hospital-authority');
    Route::get('/hospital-authority/edit/{hospital_authority_id}', 'App\Http\Controllers\Admin\HospitalAuthorityController@edit')->name('adminEditHospitalAuthority')->middleware('checkAuth:admin|hospital-authority');
    Route::post('/hospital-authority/{hospital_authority_id}', 'App\Http\Controllers\Admin\HospitalAuthorityController@save')->name('adminSaveHospitalAuthority')->middleware('checkAuth:admin|hospital-authority');

    Route::get('/user-authority', 'App\Http\Controllers\Admin\UserAuthorityController@index')->name('adminUserAuthorityList')->middleware('checkAuth:admin|user-authority');
    Route::get('/user-authority/status/{user_authority_id}/{status}', 'App\Http\Controllers\Admin\UserAuthorityController@updateStatus')->name('adminUpdateUserAuthorityStatus')->middleware('checkAuth:admin|user-authority');
    Route::get('/user-authority/{user_authority_id}', 'App\Http\Controllers\Admin\UserAuthorityController@show')->name('adminUserAuthority')->middleware('checkAuth:admin|user-authority');
    Route::get('/user-authority/edit/{user_authority_id}', 'App\Http\Controllers\Admin\UserAuthorityController@edit')->name('adminEditUserAuthority')->middleware('checkAuth:admin|user-authority');
    Route::post('/user-authority/{user_authority_id}', 'App\Http\Controllers\Admin\UserAuthorityController@save')->name('adminSaveUserAuthority')->middleware('checkAuth:admin|user-authority');

});

// 醫院
Route::prefix('hospital')->group(function () {
    Route::get('/', 'App\Http\Controllers\Hospital\IndexController@login')->name('hospitalRoot');
    Route::post('/login', 'App\Http\Controllers\Hospital\IndexController@login')->name('hospitalLogin');
    Route::post('/logout', 'App\Http\Controllers\Hospital\IndexController@logout')->name('hospitalLogout');
    // 後面的 middleware 是為了驗證即取得權限
    // 可以填 群組|none 就可以預先取得使用者權限
    // 另外這裡只是範例 DASHBOARD 不該有權限驗證
    Route::get('/dashboard', 'App\Http\Controllers\Hospital\DashboardController@index')->name('hospitalDashboard')->middleware('checkAuth:hospital|dashboard');
});

Route::get('/', 'App\Http\Controllers\User\IndexController@login')->name('userRoot');
Route::post('/login', 'App\Http\Controllers\User\IndexController@login')->name('userLogin');
Route::post('/logout', 'App\Http\Controllers\User\IndexController@logout')->name('userLogout');
Route::get('/dashboard', 'App\Http\Controllers\User\DashboardController@index')->name('userDashboard')->middleware('checkAuth:user|none');
