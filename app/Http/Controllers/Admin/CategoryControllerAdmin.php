<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryControllerAdmin extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with('children')->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function getChildren($id)
    {
        $categories = Category::where('parent_id', $id)->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'has_children' => $category->children()->exists(), // Kiểm tra nếu có danh mục con
            ];
        });

        return response()->json($categories);
    }


    public function createChild($parentId)
    {
        $parentCategory = Category::findOrFail($parentId);
        $categories = Category::whereNull('parent_id')->orWhere('parent_id', '!=', $parentId)->get();

        return view('admin.category.create_child', compact('parentCategory', 'categories'));
    }


    public function unlinkChild($id)
    {
        $category = Category::findOrFail($id);

        // Đặt parent_id về null để loại bỏ quan hệ cha-con
        $category->parent_id = null;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Đã loại bỏ danh mục con khỏi danh mục cha']);
    }

    public function unlinkCategory($id)
    {
        $category = Category::findOrFail($id);

        // Chuyển danh mục con thành danh mục độc lập
        $category->update(['parent_id' => null]);

        return response()->json(['success' => true, 'message' => 'Danh mục đã được loại bỏ khỏi danh mục cha!']);
    }


    public function assignChild(Request $request)
    {
        $request->validate([
            'parent_id' => 'required|exists:categories,id',
            'child_id' => 'required|exists:categories,id|different:parent_id',
        ]);

        $childCategory = Category::findOrFail($request->child_id);
        $childCategory->parent_id = $request->parent_id;
        $childCategory->save();

        return redirect()->route('admin.category.index')->with('success', 'Gán danh mục con thành công!');
    }


    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->parent_id = $request->parent_id ?? null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('success', 'Danh mục được thêm thành công!');
    }


    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('admin.category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            // Lưu ảnh mới vào storage/public/categories
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'image' => $category->image, // Cập nhật ảnh nếu có thay đổi
        ]);

        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được cập nhật.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Kiểm tra nếu có danh mục con thì cập nhật parent_id thành null
        if ($category->children()->count() > 0) {
            $category->children()->update(['parent_id' => null]);
        }

        // Xóa danh mục cha
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được xóa. Các danh mục con đã trở thành danh mục độc lập.');
    }
}
