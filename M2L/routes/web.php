<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index'); // Si votre fichier est resources/views/mon-accueil.blade.php
});
Route::get('/accueil', function () {
    return view('accueil'); // Si votre fichier est resources/views/apropos.blade.php
});
Route::get('/profil', function () {
    return view('profil'); // Si votre fichier est resources/views/apropos.blade.php
});
Route::get('/liste', function () {
    return view('liste'); // Si votre fichier est resources/views/apropos.blade.php
});