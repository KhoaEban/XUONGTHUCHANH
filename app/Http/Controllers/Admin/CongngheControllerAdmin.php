<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Congnghe;
use App\Models\Khoa;

class CongngheControllerAdmin extends Controller
{
    public function index()
    {
        $congnghes = Congnghe::orderBy('created_at', 'desc')->get();
        return view('admin.congnghe.index', compact('congnghes'));

    }

    public function create()
    {
        $khoas = Khoa::all();
        return view('admin.congnghe.create', compact('khoas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaCongNghe' => 'required|string|max:50|unique:congnghes',
            'TenCongNghe' => 'required|string|max:100',
            'KhoaID' => 'required|exists:khoas,id',
        ]);

        $congnghe = new Congnghe();
        $congnghe->MaCongNghe = $request->MaCongNghe;
        $congnghe->TenCongNghe = $request->TenCongNghe;
        $congnghe->KhoaID = $request->KhoaID;
        $congnghe->save();

        return redirect()->route('admin.congnghe.index')-> with('success', 'Thêm công nghệ thành công');
    }

    public function show($id)
    {
        $congnghe = Congnghe::findOrFail($id);
        return view('admin.congnghe.show', compact('congnghe'));
    }

    public function edit($id)
    {
        $congnghe = Congnghe::findOrFail($id);
        $khoas = Khoa::all();
        return view('admin.congnghe.edit', compact('congnghe', 'khoas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'MaCongNghe' => 'required|string|max:50|unique:congnghes,MaCongNghe,' . $id,
            'TenCongNghe' => 'required|string|max:100',
            'KhoaID' => 'required|exists:khoas,id',
        ]);

        $congnghe = Congnghe::findOrFail($id);
        $congnghe->MaCongNghe = $request->MaCongNghe;
        $congnghe->TenCongNghe = $request->TenCongNghe;
        $congnghe->KhoaID = $request->KhoaID;
        $congnghe->save();

        return redirect()->route('admin.congnghe.index')->with('success', 'Cập nhật công nghệ thành công');
    }

    public function destroy($id)
    {
        $congnghe = Congnghe::findOrFail($id);
        $congnghe->delete();
        return redirect()->route('admin.congnghe.index')->with('success', 'Xóa công nghệ thành công');
    }


}
