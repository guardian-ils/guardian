<?php

namespace Guardian\Controllers;

use Guardian\Helper\Uuid;
use Guardian\Requests\Branch\UpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            'data' => $branches,
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

    /**
     * @param $branch Branch ID
     * @param UpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($branch, UpdateRequest $request)
    {
        if (!Uuid::valid($branch)) {
            return response()->json(['result' => 'failed'])->setStatusCode(422);
        }

        try {
            $instance = Branch::findOrFail($branch);
        } catch (ModelNotFoundException $e) {
            return response(['result' => 'failed'])->setStatusCode(404);
        }

        foreach ($request->getForm()->all() as $key => $value) {
            $instance->setAttribute($key, $value);
        }
        $instance->save();

        return response()->json(['result' => 'success']);
    }

    /**
     * @param $branch Branch ID from Url
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($branch)
    {
        if (!Uuid::valid($branch)) {
            return response()->json(['result' => 'failed'])->setStatusCode(422);
        }

        try {
            Branch::findOrFail($branch)->delete();
            return response()->json(['result' => 'success']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['result' => 'failed'])->setStatusCode(404);
        }
    }

}
