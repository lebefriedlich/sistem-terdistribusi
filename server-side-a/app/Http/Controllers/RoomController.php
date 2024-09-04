<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['category'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Kamar Berhasil Ditampilkan',
            'data' => $rooms
        ]);
    }

    public function store(Request $request)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'exists' => ':attribute tidak ditemukan',
            'unique' => ':attribute sudah terdaftar'
        ];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'room_number' => 'required|unique:rooms',
            'price' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kamar Gagal Ditambahkan',
                'errors' => $validator->errors(),
            ], 422);
        }

        $room = Room::create([
            'category_id' => $request->category_id,
            'room_number' => $request->room_number,
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Kamar Berhasil Ditambahkan',
            'data' => $room,
        ], 201);
    }

    public function show($id)
    {
        $room = Room::with(['category'])->find($id);
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kamar Tidak Ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Kamar Berhasil Ditampilkan',
            'data' => $room,
        ]);
    }

    public function update(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'exists' => ':attribute tidak ditemukan',
            'unique' => ':attribute sudah terdaftar',
            'in' => ':attribute harus salah satu dari: :values',
        ];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'room_number' => 'required|unique:rooms',
            'price' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kamar Gagal Diubah',
                'errors' => $validator->errors(),
            ], 422);
        }

        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kamar Tidak Ditemukan',
            ], 404);
        }

        $room->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data Kamar Berhasil Diubah',
            'data' => $room,
        ]);
    }

    public function update_post(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'exists' => ':attribute tidak ditemukan',
            'unique' => ':attribute sudah terdaftar',
        ];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'room_number' => 'required',
            'price' => 'required',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kamar Gagal Diubah',
                'errors' => $validator->errors(),
            ], 422);
        }

        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kamar Tidak Ditemukan',
            ], 404);
        }

        $room->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data Kamar Berhasil Diubah',
            'data' => $room,
        ]);
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kamar Tidak Ditemukan',
            ], 404);
        }

        $room->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Kamar Berhasil Dihapus',
        ]);
    }
}
