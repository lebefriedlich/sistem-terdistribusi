<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VCategoryController extends Controller
{
    public function index()
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/categoriesV';
        $response = $client->request('GET', $apiUrl);
        $categories = json_decode($response->getBody()->getContents());
        if ($response->getStatusCode() == 200) {
            return view('dashboard.admin.categoriesV', ['categories' => $categories]);
        }
    }

    public function store(Request $request)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/categoriesV';

        try {
            $response = $client->request('POST', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Cache::get('token1')
                ],
                'multipart' => [
                    [
                        'name'     => 'name',
                        'contents' => $request->name
                    ],
                    [
                        'name'     => 'type',
                        'contents' => $request->type
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
                return redirect()->route('categoriesV.index')->with('success', $responseData['message']);
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $responseBody = $response ? $response->getBody()->getContents() : 'No response from server';

            $responseData = json_decode($responseBody, true);
            $errorMessage = $responseData['message'];
            $errors = $responseData['errors'] ?? [];

            return redirect()->route('categoriesV.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }

    public function edit(Request $request, $id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/categoriesV/' . $id;
        try {
            $multipart = [
                [
                    'name'     => 'name',
                    'contents' => $request->name
                ],
                [
                    'name'     => 'type',
                    'contents' => $request->type
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
                    'Authorization' => 'Bearer ' . Cache::get('token1')
                ],
                'multipart' => $multipart
            ]);

            if ($response->getStatusCode() == 200) {
                $responseData = json_decode($response->getBody()->getContents(), true);
                return redirect()->route('categoriesV.index')->with('success', $responseData['message']);
            }
        } catch (RequestException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $responseData = json_decode($responseBody, true);

            $errorMessage = $responseData['message'];
            $errors = $responseData['errors'];

            return redirect()->route('categoriesV.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }

    public function delete($id)
    {
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8001/api/categoriesV/' . $id;

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
                    return redirect()->route('categoriesV.index')->with('success', $responseData['message']);
                } else {
                    return redirect()->route('categoriesV.index')->withErrors(['api' => 'Unexpected response format.']);
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

            return redirect()->route('categoriesV.index')
                ->withErrors(['api' => $errorMessage])
                ->withInput();
        }
    }
}
