<?php

namespace App\Http\Controllers;

use App\Models\CustomersModel;
use App\Models\RentalsModel;
use App\Models\VehiclesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentalController extends Controller
{
    public function getAvailable($id_category, $start_date, $end_date)
    {
        $available = VehiclesModel::where('category_id', $id_category)
            ->whereDoesntHave('rentals', function ($query) use ($start_date, $end_date) {
                $query->where(function ($query) use ($start_date, $end_date) {
                    $query->where('start_date', '>=', $start_date)
                        ->where('start_date', '<', $end_date);
                })->orWhere(function ($query) use ($start_date, $end_date) {
                    $query->where('end_date', '>', $start_date)
                        ->where('end_date', '<=', $end_date);
                })->orWhere(function ($query) use ($start_date, $end_date) {
                    $query->where('start_date', '<', $start_date)
                        ->where('end_date', '>', $end_date);
                });
            })
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Kendaraan Tersedia Berhasil Ditampilkan',
            'data' => $available
        ]);
    }

    public function rented(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi',
            'email' => ':attribute harus berupa email',
            'exists' => ':attribute tidak ditemukan',
            'date' => ':attribute harus berupa tanggal'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'total_price' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Diverifikasi',
                'data' => $validator->errors()
            ], 400);
        }

        $customer = CustomersModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $rental = RentalsModel::create([
            'vehicle_id' => $request->vehicle_id,
            'customer_id' => $customer->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $request->total_price,
            'status' => 'paid'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan Berhasil Disewa',
            'data' => $rental
        ], 201);
    }

    public function getRental()
    {
        $rental = RentalsModel::with('customer', 'vehicle', 'vehicle.category')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Rental Berhasil Ditampilkan',
            'data' => $rental
        ]);
    }

    public function startRent(Request $request, $id)
    {
        $rental = RentalsModel::find($id);
        if (!$rental) {
            return response()->json([
                'success' => false,
                'message' => 'Data rental tidak ditemukan',
            ], 404);
        }

        $rental->status = 'started';
        $rental->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengambilan Unit Selesai',
            'data' => $rental
        ], 201);
    }

    public function finishRent(Request $request, $id)
    {
        $rental = RentalsModel::find($id);
        if (!$rental) {
            return response()->json([
                'success' => false,
                'message' => 'Data rental tidak ditemukan',
            ], 404);
        }

        $rental->status = 'finished';
        $rental->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengembalian Unit Selesai',
            'data' => $rental
        ], 201);
    }
}
