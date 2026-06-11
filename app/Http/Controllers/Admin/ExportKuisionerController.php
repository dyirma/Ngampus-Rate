<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\HasilKuisionerExport;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportKuisionerController extends Controller
{
    public function export(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $periode = $request->query('periode', date('Y'));
        
        // Buat nama file dinamis sesuai nama kategori
        $filename = 'Hasil_Kuesioner_' . str_replace(' ', '_', $category->nama_kategori) . '_' . $periode . '.xlsx';
        
        return Excel::download(new HasilKuisionerExport($categoryId, $periode), $filename);
    }
}
