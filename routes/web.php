<?php

Route::get('/', function () {
    return view('home');  
});

Route::get('/dashboard', function () {
    return view('dashboard');  
})->name('dashboard');

Route::get('/video-tutorial', function () {
    return view('video_tutorial');  
})->name('video_tutorial');

Route::get('/user', function () {
    return view('user');  
})->name('user');

Route::get('/financial-statements', function () {
    return view('financial_statements');  
})->name('financial_statements');

Route::get('/total-projects', function () {
    return view('total_projects');  
})->name('total_projects');

Route::get('/income', function () {
    return view('income');  
})->name('income');

Route::get('/expense', function () {
    return view('expense');  
})->name('expense');
