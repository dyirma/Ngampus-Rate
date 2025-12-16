<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
use Illuminate\Http\Request;

class AdminKuisionerController extends Controller
{
    public function index()
    {
        $kuisioners = Kuisioner::withCount('pertanyaan')->orderBy('id')->paginate(10);

        return view('admin.kuisioner.index', compact('kuisioners'));
    }

    public function create()
    {
        return view('admin.kuisioner.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kuisioner' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Kuisioner::create($data);

        return redirect()->route('admin.kuisioner.index')->with('status', 'Kuisioner berhasil dibuat.');
    }

    public function edit(Kuisioner $kuisioner)
    {
        return view('admin.kuisioner.edit', compact('kuisioner'));
    }

    public function update(Request $request, Kuisioner $kuisioner)
    {
        $data = $request->validate([
            'nama_kuisioner' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $kuisioner->update($data);

        return redirect()->route('admin.kuisioner.index')->with('status', 'Kuisioner berhasil diperbarui.');
    }

    public function destroy(Kuisioner $kuisioner)
    {
        $kuisioner->delete();

        return redirect()->route('admin.kuisioner.index')->with('status', 'Kuisioner berhasil dihapus.');
    }
}
<?php

