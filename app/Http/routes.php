<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', 'InvBaseController@ShowFull');

Route::any('/jsonport', 'InvBaseController@Update');

Route::any('/register', 'InvBaseController@Register');

Route::any('/information', function () {
    return view('onebutton');
});
Route::any('/informationport', 'InvBaseController@Info');

//отцеплено head