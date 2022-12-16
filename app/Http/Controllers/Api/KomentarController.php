<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class KomentarController extends Controller
{
    public function index()
    {

        $pesanan = Komentar::all();

        if (count($pesanan) > 0) {
            return response()->json([
                'message'   => 'List Data Komentar',
                'data'      => $pesanan
            ], 200);
        };

        return response()->json([
            'message'   => 'Masih Kosong Data Komentar',
            'data'      => null
        ], 200);
    }



    public function show($id)
    {

        $pesanan = Komentar::find($id);

        if (!is_null($pesanan)) {
            return response()->json([
                'message'   => 'Retrieve Komentar Success',
                'data'      => $pesanan
            ], 200);
        }

        return response()->json([
            'message'   => 'Komentar Not Found',
            'data'      => null
        ], 404);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'jenis_komentar' => 'required',
            'nama_makanan'   => 'required',
            'cacatan'        => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'data'      => $validator->errors()
            ], 400);
        }

        $pesanan = Komentar::create([
            'jenis_komentar'          => $request->jenis_komentar,
            'nama_makanan'   => $request->nama_makanan,
            'cacatan'   => $request->cacatan,
        ]);


        if ($pesanan) {
            return response()->json([
                'message'   => 'Komentar Created',
                'data'      => $pesanan,
            ], 201);
        }

        return response()->json([
            'message'   => 'Komentar Failed to Save',
            'data'      => null,
        ], 400);
    }

    public function edit()
    {
    }
    public function update(Request $request, $id)
    {

        $pesanan = Komentar::find($id);

        if (is_null($pesanan)) {
            return response()->json([
                'message'   => 'Komentar Not Found',
                'data'      => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'jenis_komentar' => 'required',
            'nama_makanan'   => 'required',
            'cacatan'        => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);


        $pesanan->update($updateData);

        return response()->json([
            'message'   => 'Update Komentar Success',
            'data'      => $pesanan
        ], 200);
    }

    public function destroy($id)
    {

        $pesanan = Komentar::find($id);

        if (is_null($pesanan)) {
            return response()->json([
                'message'   => 'Komentar Not Found',
                'data'      => null
            ], 404);
        }

        $pesanan->delete();

        return response()->json([
            'message'   => 'Delete Komentar Success',
            'data'      => $pesanan
        ], 200);
    }
}
