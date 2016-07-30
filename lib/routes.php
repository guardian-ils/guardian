<?php

Route::get('api/v1/branches', 'Guardian\Controllers\BranchController@listing');
Route::post('/api/v1/branches', 'Guardian\Controllers\BranchController@create');
