<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jasa;

class AdminJasaController extends Controller
{
    public function index()
    {
        $jasa = Jasa::all();
        return view('backend.admin.jasa', compact('jasa'));
    }

    public function create()
    {
        return view('backend.admin.jasa_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
        ]);
        Jasa::create($request->all());
        return redirect()->route('admin.jasa.index')->with('success', 'Jasa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jasa = Jasa::findOrFail($id);
        return view('backend.admin.jasa_edit', compact('jasa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
        ]);
        $jasa = Jasa::findOrFail($id);
        $jasa->update($request->all());
        return redirect()->route('admin.jasa.index')->with('success', 'Jasa berhasil diupdate');
    }

    public function destroy($id)
    {
        $jasa = Jasa::findOrFail($id);
        $jasa->delete();
        return redirect()->route('admin.jasa.index')->with('success', 'Jasa berhasil dihapus');
    }
}
