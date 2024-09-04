<?php

namespace App\Http\Controllers;

use Cache;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as FacadesCache;

class DashboardController extends Controller
{
    public function index()
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/get-reservasi';
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . FacadesCache::get('token'),
            ]
        ]);
        $reservasiHotel = json_decode($response->getBody()->getContents());

        $apiUrl = 'http://127.0.0.1:8001/api/get-rental';
        $response1 = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . FacadesCache::get('token1'),
            ]
        ]);
        $rentalVehicle = json_decode($response1->getBody()->getContents());

        if ($response->getStatusCode() == 200 && $response1->getStatusCode() == 200) {
            return view('dashboard.admin.index', [
                'reservasiHotel' => $reservasiHotel,
                'rentalVehicle' => $rentalVehicle
            ]);
        }
    }

    public function checkIn($id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/check-in/' . $id;
        $response = $client->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . FacadesCache::get('token'),
            ]
        ]);
        $responseData = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() == 201) {
            return redirect()->route('dashboard.index')->with('success', $responseData['message']);
        }
    }

    public function checkOut($id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/check-out/' . $id;
        $response = $client->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . FacadesCache::get('token'),
            ]
        ]);
        $responseData = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() == 201) {
            return redirect()->route('dashboard.index')->with('success', $responseData['message']);
        }
    }

    public function startRent($id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/start-rent/' . $id;
        $response = $client->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . FacadesCache::get('token1'),
            ]
        ]);
        $responseData = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() == 201) {
            return redirect()->route('dashboard.index')->with('success', $responseData['message']);
        }
    }

    public function endRent($id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/finish-rent/' . $id;
        $response = $client->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . FacadesCache::get('token1'),
            ]
        ]);
        $responseData = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() == 201) {
            return redirect()->route('dashboard.index')->with('success', $responseData['message']);
        }
    }
}
