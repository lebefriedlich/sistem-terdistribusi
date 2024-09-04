<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi',
            'email' => ':attribute tidak valid',
            'string' => ':attribute harus berupa string',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'user') {
                return redirect()->route('landing_page.index');
            }
        } else {
            try {
                $client = new Client();

                $apiUrl = 'http://127.0.0.1:8000/api/login';
                $response = $client->request('POST', $apiUrl, [
                    'form_params' => [
                        'email' => $request->email,
                        'password' => $request->password,
                    ]
                ]);
                $responseData = json_decode($response->getBody()->getContents());

                $apiUrl1 = 'http://127.0.0.1:8001/api/login';
                $response1 = $client->request('POST', $apiUrl1, [
                    'form_params' => [
                        'email' => $request->email,
                        'password' => $request->password,
                    ]
                ]);
                $responseData1 = json_decode($response1->getBody()->getContents());

                if ($response->getStatusCode() == 200 && $response1->getStatusCode() == 200) {
                    Cache::put('token', $responseData->token, now()->addMinutes(60));
                    Cache::put('token1', $responseData1->token, now()->addMinutes(60));
                    Cache::put('admin', $responseData->data, now()->addMinutes(60));
                    return redirect()->route('dashboard.index');
                } else {
                    return redirect()->back()->with('error', 'Login failed. Please try again.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred. Please try again.');
            }
        }
    }


    public function register()
    {
        return view('register');
    }

    public function postRegister(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi',
            'email' => ':attribute tidak valid',
            'string' => ':attribute harus berupa string',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maksimal :max karakter',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'phone' => 'required|string|min:10|max:13',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'role' => 'user',
        ]);

        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function logout_admin()
    {
        
        $client = new Client();
        $apiUrl = 'http://127.0.0.1:8000/api/logout';
        $response = $client->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('token')
            ],
        ]);
        
        $apiUrl1 = 'http://127.0.0.1:8001/api/logout';
        $response1 = $client->request('POST', $apiUrl1, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('token1')
            ],
        ]);
        
        Cache::forget('token');
        Cache::forget('token1');

        if ($response->getStatusCode() == 200 && $response1->getStatusCode() == 200) {
            return redirect()->route('login');
        }
    }
}
