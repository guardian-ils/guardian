<?php

Route::group([
    'namespace' => 'Guardian\Controllers',
    'prefix' => 'api/v1'
], function () {
    Route::resources('branches', 'BranchController', [
        'only' => ['index', 'store']
    ]);
});
