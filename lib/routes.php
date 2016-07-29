<?php

use Illuminate\Http\Response;

Route::get('/api/v1/branches', function () {
    $content = [
      'result' => 'success',
      'data' => [],
    ];
    return (new Response(json_encode($content), 200))
                ->header('Content-Type', 'application/json');
});

Route::post('/api/v1/branches', function () {
    $content = [
      'result' => 'success',
      'data' => [],
    ];
    return (new Response(json_encode($content), 201))
                ->header('Content-Type', 'application/json');
});
