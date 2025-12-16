<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuisioner;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class AdminPertanyaanController extends Controller
{
    public function index(Kuisioner $kuisioner)
    {
        $pertanyaans = $kuisioner->pertanyaan()->orderBy('id')->paginate(15);

        return view('admin.pertanyaan.index', compact('kuisioner', 'pertanyaans'));
    }

    public function create(Kuisioner $kuisioner)
    {
        return view('admin.pertanyaan.create', compact('kuisioner'));
    }

    public function store(Request $request, Kuisioner $kuisioner)
    {
        $data = $request->validate([
            'teks_pertanyaan' => ['required', 'string'],
            'tipe_jawaban' => ['required', 'in:likert,text,dropdown'],
            'opsi_dropdown' => ['nullable', 'array'],
            'opsi_dropdown.*' => ['nullable', 'string'],
        ]);

        if ($data['tipe_jawaban'] !== 'dropdown') {
            $data['opsi_dropdown'] = null;
        } else {
            $data['opsi_dropdown'] = $this->sanitizeDropdownOptions($data['opsi_dropdown'] ?? []);
        }

        $kuisioner->pertanyaan()->create($data);

        return redirect()->route('admin.kuisioner.pertanyaan.index', $kuisioner)->with('status', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(Kuisioner $kuisioner, Pertanyaan $pertanyaan)
    {
        return view('admin.pertanyaan.edit', compact('kuisioner', 'pertanyaan'));
    }

    public function update(Request $request, Kuisioner $kuisioner, Pertanyaan $pertanyaan)
    {
        $data = $request->validate([
            'teks_pertanyaan' => ['required', 'string'],
            'tipe_jawaban' => ['required', 'in:likert,text,dropdown'],
            'opsi_dropdown' => ['nullable', 'array'],
            'opsi_dropdown.*' => ['nullable', 'string'],
        ]);

        if ($data['tipe_jawaban'] !== 'dropdown') {
            $data['opsi_dropdown'] = null;
        } else {
            $data['opsi_dropdown'] = $this->sanitizeDropdownOptions($data['opsi_dropdown'] ?? []);
        }

        $pertanyaan->update($data);

        return redirect()->route('admin.kuisioner.pertanyaan.index', $kuisioner)->with('status', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(Kuisioner $kuisioner, Pertanyaan $pertanyaan)
    {
        $pertanyaan->delete();

        return redirect()->route('admin.kuisioner.pertanyaan.index', $kuisioner)->with('status', 'Pertanyaan berhasil dihapus.');
    }

    private function sanitizeDropdownOptions(array $options): array
    {
        return collect($options)
            ->flatMap(fn ($value) => preg_split('/[,|\n]/', (string) $value))
            ->map(fn ($value) => trim($value))
            ->filter()
            ->values()
            ->all();
    }
}
