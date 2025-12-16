<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class AdminDosenController extends Controller
{
    public function index()
    {
        $dosens = Dosen::orderBy('nama')->paginate(10);

        return view('admin.dosens.index', compact('dosens'));
    }

    public function create()
    {
        return view('admin.dosens.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50', 'unique:dosens,nip'],
        ]);

        Dosen::create($data);

        return redirect()->route('admin.dosen.index')->with('status', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen)
    {
        return view('admin.dosens.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:50', 'unique:dosens,nip,'.$dosen->id],
        ]);

        $dosen->update($data);

        return redirect()->route('admin.dosen.index')->with('status', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()->route('admin.dosen.index')->with('status', 'Data dosen berhasil dihapus.');
    }
}
