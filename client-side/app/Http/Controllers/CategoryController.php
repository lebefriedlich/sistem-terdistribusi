<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index()
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/category';
        $response = $client->request('GET', $apiUrl);
        $categories = json_decode($response->getBody()->getContents());
        if ($response->getStatusCode() == 200) {
            return view('dashboard.admin.category', ['categories' => $categories]);
        }
    }

    public function store(Request $request)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/category';

        try {
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token')
                ],
                'multipart' => [
                    [
                        'name'     => 'name',
                        'contents' => $request->name
                    ],
                    [
                        'name'     => 'image',
                        'contents' => fopen($request->file('image')->getPathname(), 'r'),
                        'filename' => $request->file('image')->getClientOriginalName()
                    ],
                    [
                        'name'     => 'description',
                        'contents' => $request->description
                    ]
                ]
            ]);

            if ($response->getStatusCode() == 201) {
                $responseData = json_decode($response->getBody()->getContents(), true);
                return redirect()->route('category-hotel.index')->with('success', $responseData['message']);
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $responseBody = $response ? $response->getBody()->getContents() : 'No response from server';

            $responseData = json_decode($responseBody, true);
            $errorMessage = $responseData['message'];
            $errors = $responseData['errors'] ?? [];

            return redirect()->route('category-hotel.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }

    public function edit(Request $request, $id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/category/' . $id;
        try {
            $multipart = [
                [
                    'name'     => 'name',
                    'contents' => $request->name
                ],
                [
                    'name'     => 'description',
                    'contents' => $request->description
                ]
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $multipart[] = [
                    'name'     => 'image',
                    'contents' => fopen($file->getPathname(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ];
            }

            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token')
                ],
                'multipart' => $multipart
            ]);

            if ($response->getStatusCode() == 200) {
                $responseData = json_decode($response->getBody()->getContents(), true);
                return redirect()->route('category-hotel.index')->with('success', $responseData['message']);
            }
        } catch (RequestException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            $errorMessage = $responseData['message'];
            $errors = $responseData['errors'];

            return redirect()->route('category.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }

    public function delete($id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/category/' . $id;

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
                    return redirect()->route('category-hotel.index')->with('success', $responseData['message']);
                } else {
                    return redirect()->route('category-hotel.index')->withErrors(['api' => 'Unexpected response format.']);
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

            return redirect()->route('category-hotel.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }
}
