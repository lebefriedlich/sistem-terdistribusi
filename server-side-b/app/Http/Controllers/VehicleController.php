<?php

namespace App\Http\Controllers;

use App\Models\VehiclesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = VehiclesModel::with('category')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Kendaraan Berhasil Ditampilkan',
            'data' => $vehicles
        ]);
    }
    
    public function store(Request $request, )
    {
        $message = [
            'required' => ':attribute harus diisi',
            'exists' => ':attribute tidak ditemukan',
            'unique' => ':attribute sudah ada',
        ];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'plate_number' => 'required|unique:vehicles,plate_number',
            'price' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data kendaraan Gagal Ditambahkan',
                'errors' => $validator->errors(),
            ], 422);
        }

        $vehicle = VehiclesModel::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data Kendaraan Berhasil Ditambahkan',
            'data' => $vehicle
        ], 201);
    }

    public function show($id)
    {
        $vehicle = VehiclesModel::with('category')->find($id);
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kendaraan Tidak Ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Kendaraan Berhasil Ditampilkan',
            'data' => $vehicle
        ]);
    }

    public function update(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus diisi',
            'exists' => ':attribute tidak ditemukan',
            'unique' => ':attribute sudah ada',
        ];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'plate_number' => 'required|unique:vehicles,plate_number,' . $id,
            'price' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kendaraan Gagal Diupdate',
                'errors' => $validator->errors(),
            ], 422);
        }

        $vehicle = VehiclesModel::find($id);
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kendaraan Tidak Ditemukan',
            ], 404);
        }

        $vehicle->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data Kendaraan Berhasil Diupdate',
            'data' => $vehicle
        ]);
    }

    public function update_post(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus diisi',
            'exists' => ':attribute tidak ditemukan',
            'unique' => ':attribute sudah ada',
        ];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'plate_number' => 'required|unique:vehicles,plate_number,' . $id,
            'price' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kendaraan Gagal Diupdate',
                'errors' => $validator->errors(),
            ], 422);
        }

        $vehicle = VehiclesModel::find($id);
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kendaraan Tidak Ditemukan',
            ], 404);
        }

        $vehicle->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data Kendaraan Berhasil Diupdate',
            'data' => $vehicle
        ]);
    }

    public function destroy($id)
    {
        $vehicle = VehiclesModel::find($id);
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kendaraan Tidak Ditemukan',
            ], 404);
        }

        $vehicle->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Kendaraan Berhasil Dihapus',
        ]);
    }
}
