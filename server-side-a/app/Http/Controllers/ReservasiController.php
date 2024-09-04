<?php

namespace App\Http\Controllers;

use App\Models\CustomersModel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReservasiController extends Controller
{
    public function getAvailable($id_category, $checkIn, $checkOut)
    {
        $available = Room::where('category_id', $id_category)
            ->whereDoesntHave('reservations', function ($query) use ($checkIn, $checkOut) {
                $query->where(function ($query) use ($checkIn, $checkOut) {
                    $query->where('check_in', '>=', $checkIn)
                        ->where('check_in', '<', $checkOut);
                })->orWhere(function ($query) use ($checkIn, $checkOut) {
                    $query->where('check_out', '>', $checkIn)
                        ->where('check_out', '<=', $checkOut);
                })->orWhere(function ($query) use ($checkIn, $checkOut) {
                    $query->where('check_in', '<', $checkIn)
                        ->where('check_out', '>', $checkOut);
                });
            })
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Kamar Tersedia Berhasil Ditampilkan',
            'data' => $available
        ]);
    }

    public function reserved(Request $request)
    {
        $messages = [
            'required' => ':attribute harus diisi',
            'email' => ':attribute harus berupa email',
            'exists' => ':attribute tidak ditemukan',
            'date' => ':attribute harus berupa tanggal',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'total_price' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Pemesanan kamar gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $customers = CustomersModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $reservasi = Reservation::create([
            'customer_id' => $customers->id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $request->total_price,
            'status' => 'paid',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kamar berhasil dipesan',
            'data' => $reservasi
        ], 201);
    }

    public function getReservasi()
    {
        $reservasi = Reservation::with('customers', 'room', 'room.category')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Reservasi Berhasil Ditampilkan',
            'data' => $reservasi
        ]);
    }

    public function checkIn(Request $request, $id)
    {
        $reservasi = Reservation::find($id);
        if (!$reservasi) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan',
            ], 404);
        }

        $reservasi->status = 'checked_in';
        $reservasi->save();

        return response()->json([
            'success' => true,
            'message' => 'Check In Berhasil',
            'data' => $reservasi
        ], 201);
    }

    public function checkOut(Request $request, $id)
    {
        $reservasi = Reservation::find($id);
        if (!$reservasi) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak ditemukan',
            ], 404);
        }

        $reservasi->status = 'checked_out';
        $reservasi->save();

        return response()->json([
            'success' => true,
            'message' => 'Check Out Berhasil',
            'data' => $reservasi
        ], 201);
    }
}
