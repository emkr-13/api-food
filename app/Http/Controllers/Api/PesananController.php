<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PesananController extends Controller
{
    public function index()
    {

        $pesanan = Pesanan::all();

        if (count($pesanan) > 0) {
            return response()->json([
                'message'   => 'List Data Pesanan',
                'data'      => $pesanan
            ], 200);
        };

        return response()->json([
            'message'   => 'Masih Kosong Data Pesanan',
            'data'      => null
        ], 200);
    }



    public function show($id)
    {

        $pesanan = Pesanan::find($id);

        if (!is_null($pesanan)) {
            return response()->json([
                'message'   => 'Retrieve Pesanan Success',
                'data'      => $pesanan
            ], 200);
        }

        return response()->json([
            'message'   => 'Pesanan Not Found',
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
            'total_pesanan'          => 'required',
            'note_pesanan'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'data'      => $validator->errors()
            ], 400);
        }

        $pesanan = Pesanan::create([
            'nama'          => $request->nama,
            'harga'   => $request->harga,
            'total_pesanan'          => $request->total_pesanan,
            'note_pesanan'   => $request->note_pesanan,
        ]);


        if ($pesanan) {
            return response()->json([
                'message'   => 'Pesanan Created',
                'data'      => $pesanan,
            ], 201);
        }

        return response()->json([
            'message'   => 'Pesanan Failed to Save',
            'data'      => null,
        ], 400);
    }

    public function edit()
    {
    }
    public function update(Request $request, $id)
    {

        $pesanan = Pesanan::find($id);

        if (is_null($pesanan)) {
            return response()->json([
                'message'   => 'Pesanan Not Found',
                'data'      => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'nama' => 'required|max:255',
            'harga' => 'required|max:255',
            'total_pesanan'          => 'required',
            'note_pesanan'   => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);


        $pesanan->update($updateData);

        return response()->json([
            'message'   => 'Update Pesanan Success',
            'data'      => $pesanan
        ], 200);
    }

    public function destroy($id)
    {

        $pesanan = Pesanan::find($id);

        if (is_null($pesanan)) {
            return response()->json([
                'message'   => 'Pesanan Not Found',
                'data'      => null
            ], 404);
        }

        $pesanan->delete();

        return response()->json([
            'message'   => 'Delete Pesanan Success',
            'data'      => $pesanan
        ], 200);
    }
}
