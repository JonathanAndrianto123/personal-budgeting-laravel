<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'limit' => 'nullable|numeric|min:0',
        ]);
        $data['user_id'] = auth()->id();
        $data['name'] = $request->name;
        $data['type'] = $request->type;
        $data['limit'] = $request->limit;
        $category = Category::create($data);
        return response()->json(['message' => 'Kategori berhasil ditambahkan!', 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Kategori telah dihapus!']);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(['category' => $category, 'edit' => true]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'limit' => 'nullable|numeric|min:0',
        ]);

        session()->forget('editCategory');
        $category->update($request->only(['name', 'type', 'limit']));
        return response()->json(['message' => 'Kategori berhasil diperbarui!', 'category' => $category]);
    }
}
