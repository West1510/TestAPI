<?php

namespace App\Http\Controllers;

use App\Models\testapi;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index()
    {
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '-1');
        return testapi::all();
    }

    public function show($id)
    {
        return testapi::query()->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = testapi::query()->create($request->validated());

        return response($data, 201);
    }

    public function update(Request $request, $id)
    {
        $data = testapi::query()->findOrFail($id);
        $data->fill($request->validated());
        $data->save();
        return response($data, 200);
    }

    public function delete($id)
    {
        $data = testapi::query()->findOrFail($id);
        $data->delete();
        return response(null, 204);
    }
}
