<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VehicleController extends Controller
{
    public function index()
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/vehicles';
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('token1')
            ],
        ]);
        $vehicles = json_decode($response->getBody()->getContents());

        $apiUrl1 = 'http://127.0.0.1:8001/api/categoriesV';
        $response1 = $client->request('GET', $apiUrl1);
        $categories = json_decode($response1->getBody()->getContents());
        if ($response->getStatusCode() == 200) {
            return view('dashboard.admin.vehicle', [
                'vehicles' => $vehicles,
                'categories' => $categories
            ]);
        }
    }

    public function store(Request $request)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/vehicles';
        try {
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token1')
                ],
                'form_params' => [
                    'category_id' => $request->category_id,
                    'plate_number' => $request->plate_number,
                    'price' => $request->price,
                ]
            ]);
            if ($response->getStatusCode() == 201) {
                $responseData = json_decode($response->getBody()->getContents(), true);
                return redirect()->route('vehicle.index')->with('success', $responseData['message']);
            }
        } catch (RequestException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            $errorMessage = $responseData['message'];
            $errors = $responseData['errors'];

            return redirect()->route('vehicle.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }

    public function edit(Request $request, $id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/vehicles/' . $id;
        try {
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token1')
                ],
                'form_params' => [
                    'category_id' => $request->category_id,
                    'plate_number' => $request->plate_number,
                    'price' => $request->price,
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $responseData = json_decode($response->getBody()->getContents(), true);
                return redirect()->route('vehicle.index')->with('success', $responseData['message']);
            }
        } catch (RequestException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            $errorMessage = $responseData['message'];
            $errors = $responseData['errors'];

            return redirect()->route('vehicle.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }

    public function delete($id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/vehicles/' . $id;

        try {
            $response = $client->request('DELETE', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token1')
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $responseBody = $response->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                if (is_array($responseData) && isset($responseData['message'])) {
                    return redirect()->route('vehicle.index')->with('success', $responseData['message']);
                } else {
                    return redirect()->route('vehicle.index')->withErrors(['api' => 'Unexpected response format.']);
                }
            }
        } catch (RequestException $e) {
            $errorMessage = 'An error occurred: ' . $e->getMessage();
            if ($e->hasResponse()) {
                $responseBody = $e->getResponse()->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                if (is_array($responseData)) {
                    $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Error response format invalid.';
                }
            }

            return redirect()->route('vehicle.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }
}
