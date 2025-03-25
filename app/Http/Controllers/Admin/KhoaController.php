<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Khoa;

class KhoaController extends Controller
{
    public function index()
    {
        $khoas = Khoa::orderBy('created_at', 'desc')->get();
        return view('admin.khoa.index', compact('khoas'));
    }

    public function create()
    {
        return view('admin.khoa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaKhoa' => 'required|string|max:50|unique:khoa',
            'TenKhoa' => 'required|string|max:100',
        ]);

        $khoa = new Khoa();
        $khoa->MaKhoa = $request->MaKhoa;
        $khoa->TenKhoa = $request->TenKhoa;
        $khoa->save();

        return redirect()->route('admin.khoa.index')->with('success', 'Khoa hoc moi da duoc tao thanh cong!');
    }

    public function show($id){
        $khoa = Khoa::find($id);
        return view('admin.khoa.show', compact('khoa'));
    }

    public function edit($id){
        $khoa = Khoa::find($id);
        return view('admin.khoa.edit', compact('khoa'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'MaKhoa' => 'required|string|max:50|unique:khoa,MaKhoa,' . $id,
            'TenKhoa' => 'required|string|max:100',
        ]);

        $khoa = Khoa::find($id);
        $khoa->MaKhoa = $request->MaKhoa;
        $khoa->TenKhoa = $request->TenKhoa;
        $khoa->save();

        return redirect()->route('admin.khoa.index')->with('success', 'Khoa hoc da duoc cap nhat thanh cong!');
    }

    public function destroy($id){
        $khoa = Khoa::find($id);
        $khoa->delete();
        return redirect()->route('admin.khoa.index')->with('success', 'Khoa hoc da duoc xoa thanh cong!');
    }
}
