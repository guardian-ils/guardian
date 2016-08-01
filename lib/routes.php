<?php

Route::group([
    'namespace' => 'Guardian\Controllers',
    'prefix' => 'api/v1'
], function () {
    Route::resource('branches', 'BranchController', [
        'only' => ['index', 'store']
    ]);
});
