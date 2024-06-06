<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });





Route::group(['middleware' => 'guest'], function(){
    Route::get('/', [HomeController:: class, 'index'])->name('home');
    Route::get('/register', [RegistrationController:: class, 'index'])->name('registration');
    Route::post('/register', [RegistrationController:: class, 'register'])->name('processRegistration');
    Route::get('/login', [LoginController:: class, 'index'])->name('login');
    Route::post('/login', [LoginController:: class, 'login'])->name('processLogin');
});
Route::group(['middleware' => 'auth'], function(){
    Route::get('/profile', [LoginController:: class, 'profile'])->name('profile');
    Route::get('/logout', [LoginController:: class, 'logout'])->name('logout');
    Route::put('/update-profile', [LoginController:: class, 'updateProfile'])->name('updateProfile');
    Route::post('/upload-pic', [LoginController:: class, 'updateProfilePic'])->name('updateProfilePic');


});