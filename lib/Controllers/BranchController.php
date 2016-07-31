<?php

namespace Guardian\Controllers;

class BranchController extends Controller {

  public function index() {
    $content = [
      'result' => 'success',
      'data' => [],
    ];
    return response()->json($content);
  }

  public function store() {
    $content = [
      'result' => 'success',
      'data' => [],
    ];
    return response()->json($content);
  }

}
