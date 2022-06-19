<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

/*
Home Page Routes
*/

Route::get('/', function () {
    return view('home.index');
});

Route::get('/gdpr', function () {
    return view('home.index', [
        'page' => 'gdpr'
    ]);
})->name('gdpr');

Route::get('/cookies', function () {
    return view('home.index', [
        'page' => 'cookies'
    ]);
})->name('cookies');

Route::post('/contact/mail/send', "App\Http\Controllers\HomeController@SendContactMail")->name('contact.send_mail');


/*
Main App Routes
 */

Route::get('/app', function () {
    if (Auth::check()) {
        return redirect('/tasks');
    } else {
        return redirect('/login');
    };
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('tasks', 'App\Http\Controllers\TasksController@index')->name('tasks.index');
    Route::post('tasks', 'App\Http\Controllers\TasksController@store')->name('tasks.store');
    Route::post('tasks/{task}/edit', 'App\Http\Controllers\TasksController@edit')->name('tasks.edit');
    Route::post('tasks/{task}/history', 'App\Http\Controllers\TasksController@ShowHistory')->name('tasks.history');
    Route::put('tasks/{task}', 'App\Http\Controllers\TasksController@update')->name('tasks.update');
    Route::delete('tasks/{task}', 'App\Http\Controllers\TasksController@destroy')->name('tasks.destroy');
    Route::put('tasks/complete/{task}', "App\Http\Controllers\TasksController@complete")->name('tasks.complete');
    Route::get('settings', "App\Http\Controllers\SettingsController@index")->name('settings.index');
    Route::put('settings/update', "App\Http\Controllers\SettingsController@update")->name('settings.update');
    //Modules
    Route::get('modules', "App\Http\Controllers\ModulesController@index")->name('modules.index');
    Route::get('modules/activate/{module_name}', "App\Http\Controllers\ModulesController@activate_modul")->name('modules.activate_modul');
    Route::get('modules/deactivate/{module_name}', "App\Http\Controllers\ModulesController@deactivate_modul")->name('modules.deactivate_modul');


});


Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sk'])) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
});

Route::get('/auth/oauth/apple', function () {
    return Socialite::driver('apple')->redirect();
})->name('oauth.apple-login');

Route::get('/auth/oauth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('oauth.google-login');

Route::get('/auth/oauth/microsoft', function () {
    return Socialite::driver('microsoft')->redirect();
})->name('oauth.microsoft-login');

Route::post('/auth/oauth/callback/apple', "App\Http\Controllers\Auth\OauthController@AppleOauth");
Route::get('/auth/oauth/callback/google', "App\Http\Controllers\Auth\OauthController@GoogleOauth");
Route::get('/auth/oauth/callback/microsoft', "App\Http\Controllers\Auth\OauthController@MicrosoftOauth");
