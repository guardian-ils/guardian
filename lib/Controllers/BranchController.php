<?php

namespace Guardian\Controllers;

class BranchController extends Controller {

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $content = [
            'result' => 'success',
            'data' => [],
        ];
        return response()->json($content);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store() {
        $content = [
            'result' => 'success',
            'data' => [],
        ];
        return response()->json($content)->setStatusCode(201);
    }

}
