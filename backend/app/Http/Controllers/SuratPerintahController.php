<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratPerintah;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View; // Import use statement untuk View

class SuratPerintahController extends Controller
{
    public function index()
    {
        $surat = SuratPerintah::with('dasar','kepada','tujuan')->get();
        return response()->json([
            'surat' => $surat
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_sp' => 'required|numeric',
            'bidang' => 'required|string',
            'dari' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $surat = new SuratPerintah([
            'no_sp' => $request->no_sp,
            'bidang' => $request->bidang,
            'dari' => $request->dari,
            'tanggal' => $request->tanggal,
        ]);

        if (!empty($request['formatt_surat_perintahs_id'])) {
            $surat->formatt_surat_perintahs_id = $request['formatt_surat_perintahs_id'];
        } else if(!empty($request['formatt_surat_perintahs2_id'])) {
            $surat->formatt_surat_perintahs2_id = $request['formatt_surat_perintahs2_id'];
        }

        $surat->save();

        if (!empty($request['dasar'])) {
            foreach ($request['dasar'] as $dariData) {
                $surat->dasar()->create([
                    'kegiatan' => $dariData['kegiatan'],
                ]);
            }
        }

        if (!empty($request['untuk2'])) {
            $surat->untuk2()->create([
                'untuk' => $request['untuk2']['untuk'],
                'lamaperjalanan' => $request['untuk2']['lamaperjalanan'],
                'biayaperjalanan' => $request['untuk2']['biayaperjalanan'],
            ]);
        }
        

        if (!empty($request['disampaikan'])) {
            foreach ($request['disampaikan'] as $disampaikanData) {
                $surat->disampaikan()->create([
                    'nama' => $disampaikanData['nama'],
                ]);
            }
        }
        
        if (!empty($request['kepada'])) {
            foreach ($request['kepada'] as $kepadaData) {
                $surat->kepada()->create([
                    'name' => $kepadaData['name'],
                    'nip' => $kepadaData['nip'],
                    'pangkat' => $kepadaData['pangkat'],
                    'jabatan' => $kepadaData['jabatan'],
                ]);
            }
        }
        
        if (!empty($request['tujuan'])) {
            foreach ($request['tujuan'] as $tujuanData) {
                $surat->tujuan()->create([
                    'untuk' => $tujuanData['untuk'],
                ]);
            }
        }

        return response()->json('Surat Berhasil Di Simpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_sp' => 'required|numeric',
            'bidang' => 'required|string',
            'dari' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $surat = SuratPerintah::findOrFail($id);

        $surat->update([
            'no_sp' => $request->no_sp,
            'bidang' => $request->bidang,
            'dari' => $request->dari,
            'tanggal' => $request->tanggal,
        ]);

        if (!empty($request['formatt_surat_perintahs_id'])) {
            $surat->formatt_surat_perintahs_id = $request['formatt_surat_perintahs_id'];
        } else if(!empty($request['formatt_surat_perintahs2_id'])) {
            $surat->formatt_surat_perintahs2_id = $request['formatt_surat_perintahs2_id'];
        }
        
        $surat->save();
        
        if (!empty($request['dasar'])) {
            $surat->dasar()->delete();
            foreach ($request['dasar'] as $dariData) {
                $surat->dasar()->create([
                    'kegiatan' => $dariData['kegiatan'],
                ]);
            }
        }

        if (!empty($request['disampaikan'])) {
            $surat->disampaikan()->delete();

            foreach ($request['disampaikan'] as $disampaikanData) {
                $surat->disampaikan()->create([
                    'nama' => $disampaikanData['nama'],
                ]);
            }
        }

        if (!empty($request['kepada'])) {
            $surat->kepada()->delete();

            foreach ($request['kepada'] as $kepadaData) {
                $surat->kepada()->create([
                    'name' => $kepadaData['name'],
                    'nip' => $kepadaData['nip'],
                    'pangkat' => $kepadaData['pangkat'],
                    'jabatan' => $kepadaData['jabatan'],
                ]);
            }
        }

        if (!empty($request['tujuan'])) {
            $surat->tujuan()->delete();
            
            foreach ($request['tujuan'] as $tujuanData) {
                $surat->tujuan()->create([
                    'untuk' => $tujuanData['untuk'],
                ]);
            }
        }

        if (!empty($request['untuk2'])) {
            $surat->untuk2()->delete();
            
            $surat->untuk2()->create([
                'untuk' => $request['untuk2']['untuk'],
                'lamaperjalanan' => $request['untuk2']['lamaperjalanan'],
                'biayaperjalanan' => $request['untuk2']['biayaperjalanan'],
            ]);
        }

        return response()->json('Surat Berhasil Di Update!');
    }

    public function delete($id)
    {
        $surat = SuratPerintah::findOrFail($id);

        $surat->dasar()->delete();
        $surat->kepada()->delete();
        $surat->tujuan()->delete();

        $surat->untuk2()->delete();
        $surat->disampaikan()->delete();

        $surat->delete();

        return response()->json('Surat Berhasil Di Delete!');
    }

    public function view(Request $request, $id, $format = 'suratperintah1')
    {
        $surat = SuratPerintah::findOrFail($id);

        if (!empty($surat->formattsuratperintah->gambar)){
            $logoPath = public_path('uploads/'. $surat->formattsuratperintah->gambar);
            $logo = base64_encode(file_get_contents($logoPath));
        }

        if (!empty($surat->formattsuratperintah2->gambar)){
            $logoPath = public_path('uploads/'. $surat->formattsuratperintah2->gambar);
            $logo = base64_encode(file_get_contents($logoPath));
        }
        
        $availableFormats = ['suratperintah1', 'suratperintah1', 'suratperintah2'];
        if (!in_array($format, $availableFormats)) {
            $format = 'suratperintah1';
        }
        

        return view('formats.sp.' . $format, compact('surat','logo'));
    }

    public function cetak(Request $request, $id, $format = 'default')
    {
        $surat = SuratPerintah::findOrFail($id);
        
        if (!empty($surat->formattsuratperintah->gambar)){
            $logoPath = public_path('uploads/'. $surat->formattsuratperintah->gambar);
            $logo = base64_encode(file_get_contents($logoPath));
        }

        if (!empty($surat->formattsuratperintah2->gambar)){
            $logoPath = public_path('uploads/'. $surat->formattsuratperintah2->gambar);
            $logo = base64_encode(file_get_contents($logoPath));
        }

        $availableFormats = ['default', 'suratperintah1', 'suratperintah2'];
        if (!in_array($format, $availableFormats)) {
            $format = 'default';
        }

        $pdf = new Dompdf();

        // Buat HTML string dari view 'pdfsp' dengan data yang diberikan
        $html = View::make('formats.sp.' . $format, compact('surat','logo'))->render();
        
        // Memuat HTML ke dalam objek Dompdf
        $pdf->loadHtml($html);

        // Set ukuran kertas dan orientasi di objek Dompdf
        $pdf->setPaper('A4', 'portrait'); // A4, potret

        // Rendering PDF
        $pdf->render();

        // Menghasilkan PDF
        return $pdf->stream();
    }
}