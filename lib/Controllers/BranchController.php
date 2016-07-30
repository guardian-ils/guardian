<?php

namespace Guardian\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class BranchController extends Controller {

  public static function listing() {
    $content = [
      'result' => 'success',
      'data' => [],
    ];
    return (new Response(json_encode($content), 200))
                ->header('Content-Type', 'application/json');
  }

  public static function create() {
    $content = [
      'result' => 'success',
      'data' => [],
    ];
    return (new Response(json_encode($content), 201))
                ->header('Content-Type', 'application/json');
  }

}
