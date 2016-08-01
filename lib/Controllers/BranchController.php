<?php

namespace Guardian\Controllers;

use Illuminate\Support\Facades\Log;
use Guardian\Models\Branch;
use Guardian\Requests\Branch\CreateRequest;

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
            $branch = Branch::create($request->getForm()->all());
            $branch->save();
            $content = ['result' => 'success'];
            $status = 201;
        } catch (\Exception $e) {
            $content = ['result' => 'failed'];
            $status = 500;
            Log::error($e);
        }

        return response()->json($content)->setStatusCode($status);
    }

}
