<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoriesModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoriesModel::all();
        return response()->json([
            'success' => true,
            'message' => 'Data Kategori Kendaraan Berhasil Ditampilkan',
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'in' => ':attribute harus diisi dengan car atau motorcycle',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg',
            'max' => ':attribute tidak boleh lebih dari 2MB',
            'string' => ':attribute harus berupa string',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required|in:car,motorcycle',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kendaraan gagal dibuat.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $slug = Str::slug($request->name);
        $path = "category/" . $request->type;
        $category = CategoriesModel::create([
            'name' => $request->name,
            'image' => $request->file('image')->storeAs($path, $slug . '.' . $request->file('image')->getClientOriginalExtension(), 'public'),
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori kendaraan berhasil dibuat.',
            'data' => $category,
        ], 201);
    }

    public function show($id)
    {
        $category = CategoriesModel::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kendaraan tidak tersedia.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kategori kendaraan berhasil ditampilkan.',
            'data' => $category
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'in' => ':attribute harus diisi dengan car atau motorcycle',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg',
            'max' => ':attribute tidak boleh lebih dari 2MB',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required|in:car,motorcycle',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required|string|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kamar gagal diperbarui.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $category = CategoriesModel::find($id);
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
            'message' => 'Kategori kendaraan berhasil diperbarui.',
            'data' => $category
        ], 200);
    }

    public function update_post(Request $request, $id)
    {
        $message = [
            'required' => ':attribute harus lengkap',
            'in' => ':attribute harus diisi dengan car atau motorcycle',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa gambar dengan format jpeg, png, jpg',
            'max' => ':attribute tidak boleh lebih dari 2MB',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required|in:car,motorcycle',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required|string|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kamar gagal diperbarui.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $category = CategoriesModel::find($id);
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
            'message' => 'Kategori kendaraan berhasil diperbarui.',
            'data' => $category
        ], 200);
    }
    public function destroy($id)
    {
        $category = CategoriesModel::find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori kendaraan tidak ditemukan.',
            ], 404);
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Kategori kendaraan berhasil dihapus.',
        ], 200);
    }
}
