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

Route::get('/', function () {
    return view('base/index');
});

Route::get('/sendVerificationMail', function (\Illuminate\Http\Request $request,
  \Illuminate\Mail\Mailer $mailer){
    $mailer
        ->to("as@as.as")
        ->send(new \App\Mail\VerificationMail("title"));
        // ->to($request->input('mail'))
        // ->send(new \App\Mail\VerificationMail($request->input('title')));
    // return redirect()->back();
})->name('sendVerificationMail');