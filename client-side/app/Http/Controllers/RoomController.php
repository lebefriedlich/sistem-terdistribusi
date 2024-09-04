<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class RoomController extends Controller
{
    public function index()
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/room';
        $response = $client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('token')
            ],
        ]);
        $rooms = json_decode($response->getBody()->getContents());

        $apiUrl1 = 'http://127.0.0.1:8000/api/category';
        $response1 = $client->request('GET', $apiUrl1);
        $categories = json_decode($response1->getBody()->getContents());
        if ($response->getStatusCode() == 200) {
            return view('dashboard.admin.room', [
                'rooms' => $rooms,
                'categories' => $categories
            ]);
        }
    }

    public function store(Request $request)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/room';
        try {
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token')
                ],
                'form_params' => [
                    'category_id' => $request->category_id,
                    'room_number' => $request->room_number,
                    'price' => $request->price
                ]
            ]);
            if ($response->getStatusCode() == 201) {
                $responseData = json_decode($response->getBody()->getContents(), true);
                return redirect()->route('room.index')->with('success', $responseData['message']);
            }
        } catch (RequestException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            $errorMessage = $responseData['message'];
            $errors = $responseData['errors'];

            return redirect()->route('room.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }

    public function edit(Request $request, $id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/room/' . $id;
        try {
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token')
                ],
                'form_params' => [
                    'category_id' => $request->category_id,
                    'room_number' => $request->room_number,
                    'price' => $request->price,
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $responseData = json_decode($response->getBody()->getContents(), true);
                return redirect()->route('room.index')->with('success', $responseData['message']);
            }
        } catch (RequestException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            $errorMessage = $responseData['message'];
            $errors = $responseData['errors'];

            return redirect()->route('room.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }

    public function delete($id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/room/' . $id;

        try {
            $response = $client->request('DELETE', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token')
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $responseBody = $response->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                if (is_array($responseData) && isset($responseData['message'])) {
                    return redirect()->route('room.index')->with('success', $responseData['message']);
                } else {
                    return redirect()->route('room.index')->withErrors(['api' => 'Unexpected response format.']);
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

            return redirect()->route('category.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }
}
