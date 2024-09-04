<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Kamar Berhasil Ditampilkan',
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg, webp',
            'max' => ':attribute tidak boleh lebih dari 2MB',
            'string' => ':attribute harus berupa string',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kamar gagal dibuat.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $slug = Str::slug($request->name);
        $category = Category::create([
            'name' => $request->name,
            'image' => $request->file('image')->storeAs('category', $slug . '.' . $request->file('image')->getClientOriginalExtension(), 'public'),
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori kamar berhasil dibuat.',
            'data' => $category,
        ], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kamar tidak tersedia.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kategori kamar berhasil ditampilkan.',
            'data' => $category
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg',
            'max' => ':attribute tidak boleh lebih dari 2MB',
            'string' => ':attribute harus berupa string',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kamar gagal diperbarui.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        $slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $imagePath = $request->file('image')->storeAs(
                'category',
                $slug . '.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );

            $category->update([
                'name' => $request->name,
                'image' => $imagePath,
                'description' => $request->description,
            ]);
        } else {
            if ($slug !== pathinfo($category->image, PATHINFO_FILENAME)) {
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    $imagePath = $slug . '.' . pathinfo($category->image, PATHINFO_EXTENSION);
                    Storage::disk('public')->move($category->image, 'category/' . $imagePath);
                    $category->image = 'category/' . $imagePath;
                }
            }

            $category->update([
                'name' => $request->name,
                'image' => $category->image,
                'description' => $request->description,
            ]);
        }
    }

    public function update_post(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg',
            'max' => ':attribute tidak boleh lebih dari 2MB',
            'string' => ':attribute harus berupa string',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kamar gagal diperbarui.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        $slug = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $imagePath = $request->file('image')->storeAs(
                'category',
                $slug . '.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );

            $category->update([
                'name' => $request->name,
                'image' => $imagePath,
                'description' => $request->description,
            ]);
        } else {
            if ($slug !== pathinfo($category->image, PATHINFO_FILENAME)) {
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    $imagePath = $slug . '.' . pathinfo($category->image, PATHINFO_EXTENSION);
                    Storage::disk('public')->move($category->image, 'category/' . $imagePath);
                    $category->image = 'category/' . $imagePath;
                }
            }

            $category->update([
                'name' => $request->name,
                'image' => $category->image,
                'description' => $request->description,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kategori kamar berhasil diperbarui.',
            'data' => $category
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kamar tidak tersedia.',
            ], 404);
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Kategori kamar berhasil dihapus.',
        ], 200);
    }
}
