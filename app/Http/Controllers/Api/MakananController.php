<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class MakananController extends Controller
{
    public function index()
    {

        $makanan = Makanan::all();

        if (count($makanan) > 0) {
            return response()->json([
                'message'   => 'List Data Makanan',
                'data'      => $makanan
            ], 200);
        };

        return response()->json([
            'message'   => 'Masih Kosong Data Makanan',
            'data'      => null
        ], 200);
    }

    public function show($id)
    {

        $makanan = Makanan::find($id);

        if (!is_null($makanan)) {
            return response()->json([
                'message'   => 'Retrieve Makanan Success',
                'data'      => $makanan
            ], 200);
        }

        return response()->json([
            'message'   => 'Makanan Not Found',
            'data'      => null
        ], 404);
    }
    public function create()
    {
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama'          => 'required',
            'harga'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'data'      => $validator->errors()
            ], 400);
        }

        $makanan = Makanan::create([
            'nama'          => $request->nama,
            'harga'   => $request->harga,
        ]);


        if ($makanan) {
            return response()->json([
                'message'   => 'Makanan Created',
                'data'      => $makanan,
            ], 201);
        }

        return response()->json([
            'message'   => 'Makanan Failed to Save',
            'data'      => null,
        ], 400);
    }

    public function edit()
    {
    }
    public function update(Request $request, $id)
    {

        $makanan = Makanan::find($id);

        if (is_null($makanan)) {
            return response()->json([
                'message'   => 'Makanan Not Found',
                'data'      => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'nama' => 'required|max:255',
            'harga' => 'required|max:255',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);


        $makanan->update($updateData);

        return response()->json([
            'message'   => 'Update Makanan Success',
            'data'      => $makanan
        ], 200);
    }

    public function destroy($id)
    {

        $makanan = Makanan::find($id);

        if (is_null($makanan)) {
            return response()->json([
                'message'   => 'Makanan Not Found',
                'data'      => null
            ], 404);
        }

        $makanan->delete();

        return response()->json([
            'message'   => 'Delete Makanan Success',
            'data'      => $makanan
        ], 200);
    }
}
