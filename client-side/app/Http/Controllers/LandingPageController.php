<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        $client = new Client();

        $apiUrl = 'http://127.0.0.1:8000/api/category';
        $response = $client->request('GET', $apiUrl);
        $categoriesHotel = json_decode($response->getBody()->getContents());

        $apiUrl = 'http://127.0.0.1:8001/api/categoriesV';
        $response1 = $client->request('GET', $apiUrl);
        $categoriesVehicle = json_decode($response1->getBody()->getContents());

        if ($response->getStatusCode() == 200 && $response1->getStatusCode() == 200) {
            return view('landing_page.index', [
                'categoriesHotel' => $categoriesHotel,
                'categoriesVehicle' => $categoriesVehicle
            ]);
        }
    }

    public function booking(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'user') {
            $client = new Client();
            $apiUrl = 'http://127.0.0.1:8000/api/booking';
            try {
                $response = $client->request('POST', $apiUrl, [
                    'form_params' => [
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone,
                        'room_id' => $request->room_id,
                        'check_in' => $request->check_in,
                        'check_out' => $request->check_out,
                        'total_price' => $request->total_price
                    ]
                ]);
                if ($response->getStatusCode() == 201) {
                    $responseData = json_decode($response->getBody()->getContents(), true);
                    return redirect()->route('landing_page.index')->with('success', $responseData['message']);
                }
                dd($response->getBody()->getContents());
            } catch (RequestException $e) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                $errorMessage = $responseData['message'] ?? 'Something went wrong';
                $errors = $responseData['errors'] ?? [];

                return redirect()->route('landing_page.index')
                    ->withErrors(['api' => $errorMessage])
                    ->withInput();
            }
        } else {
            return redirect()->route('landing_page.index')->with('error', 'Please login first');
        }
    }

    public function bookingVehicle(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'user') {
            $client = new Client();
            $apiUrl = 'http://127.0.0.1:8001/api/rental';
            try {
                $response = $client->request('POST', $apiUrl, [
                    'form_params' => [
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone,
                        'vehicle_id' => $request->vehicle_id,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'total_price' => $request->total_price
                    ]
                ]);
                if ($response->getStatusCode() == 201) {
                    $responseData = json_decode($response->getBody()->getContents(), true);
                    return redirect()->route('landing_page.index')->with('success', $responseData['message']);
                }
            } catch (RequestException $e) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                $errorMessage = $responseData['message'] ?? 'Something went wrong';
                $errors = $responseData['errors'] ?? [];

                return redirect()->route('landing_page.index')
                    ->withErrors(['api' => $errorMessage])
                    ->withInput();
            }
        } else {
            return redirect()->route('landing_page.index')->with('error', 'Please login first');
        }
    }
}
