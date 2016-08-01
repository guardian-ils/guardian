<?php

namespace Guardian\Controllers;

use Guardian\Models\Branch;
use Guardian\Requests\Branch\CreateRequest;
use Guardian\Requests\Request;

class BranchController extends Controller {

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $branches = Branch::all();
        $content = [
            'result' => 'success',
            'data' => $branches->toJson(),
        ];
        return response()->json($content);
    }

    public function store(CreateRequest $request) {
        try {
            $branch = new Branch($request->getForm()->all());
            $branch->save();
            $content = ['result' => 'success'];
            $status = 201;
        } catch (\Exception $e) {
            $content = ['result' => 'failed'];
            $status = 500;
        }
        return response()->json($content)->setStatusCode($status);
    }

}
