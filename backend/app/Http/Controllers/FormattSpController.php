<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormattSuratPerintah;
use App\Models\FormattSuratPerintah2;
use App\Http\Resources\FormattResource1;

class FormattSpController extends Controller
{
    public function index_sp_1()
    {
        $formatt = FormattSuratPerintah::with(
            'suratperintah', 
            'suratperintah.dasar',
            'suratperintah.kepada',
            'suratperintah.tujuan',
            'suratperintah.untuk2',
            'suratperintah.disampaikan',
        )->get();

        return response()->json([
            'formatt' => $formatt,
        ]);
    }

    public function get_sp_1($id)
    {
        $formatt = FormattSuratPerintah::with(
            'suratperintah',
            'suratperintah.dasar',
            'suratperintah.kepada',
            'suratperintah.tujuan',
            'suratperintah.untuk2',
            'suratperintah.disampaikan',
        )->find($id);
        return response()->json([
            'formatt' => $formatt,
        ]);
    }

    public function store_sp_1(Request $request)
    {
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke direktori server
            $gambar = $request->file('gambar');
            $gambarName = time() .'_'. $request->judul . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads'), $gambarName);
    
            $formatt = FormattSuratPerintah::create([
                'gambar' => $gambarName,
                'judul' => $request->judul,
                'nama_lembaga' => $request->nama_lembaga,
                'website' => $request->website,
                'alamat' => $request->alamat,
                'kota_pos' => $request->kota_pos,
                'ditetapkan_di' => $request->ditetapkan_di,
                'atas_nama' => $request->atas_nama,
                'an_nama' => $request->an_nama,
                'an_jabatan' => $request->an_jabatan,
                'an_nip' => $request->an_nip,
            ]);
    
            return response()->json('Formatt Berhasil Di Buat');
        }
    
        return response()->json('Gagal menyimpan gambar.', 400);
    }

    public function update_sp_1(Request $request, $id)
    {
        $formatt = FormattSuratPerintah::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() .'_'. $request->judul . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads'), $gambarName);

            if ($formatt->gambar) {
                unlink(public_path('uploads/' . $formatt->gambar));
            }

            $formatt->update([
                'gambar' => $gambarName,
                'judul' => $request->judul,
                'nama_lembaga' => $request->nama_lembaga,
                'website' => $request->website,
                'alamat' => $request->alamat,
                'kota_pos' => $request->kota_pos,
                'ditetapkan_di' => $request->ditetapkan_di,
                'atas_nama' => $request->atas_nama,
                'an_nama' => $request->an_nama,
                'an_jabatan' => $request->an_jabatan,
                'an_nip' => $request->an_nip,
            ]);
        } else {
            $formatt->update([
                'judul' => $request->judul,
                'nama_lembaga' => $request->nama_lembaga,
                'website' => $request->website,
                'alamat' => $request->alamat,
                'kota_pos' => $request->kota_pos,
                'ditetapkan_di' => $request->ditetapkan_di,
                'atas_nama' => $request->atas_nama,
                'an_nama' => $request->an_nama,
                'an_jabatan' => $request->an_jabatan,
                'an_nip' => $request->an_nip,
            ]);
        }

        return response()->json('Formatt Berhasil Di Perbarui');
    }

    public function delete_sp_1(Request $request, $id)
    {
        $formatt = FormattSuratPerintah::findOrFail($id); 

        if ($formatt->gambar) {
            unlink(public_path('uploads/' . $formatt->gambar));
        }
        
        $formatt->delete();       

        return response()->json('Formatt Data Surat Berhasil Di Delete');
    }

    public function index_sp_2()
    {
        $formatt = FormattSuratPerintah2::with(
            'suratperintah', 
            'suratperintah.dasar',
            'suratperintah.kepada',
            'suratperintah.tujuan',
            'suratperintah.untuk2',
            'suratperintah.disampaikan',
        )->get();

        return response()->json([
            'formatt' => $formatt,
        ]);
    }

    public function get_sp_2($id)
    {
        $formatt = FormattSuratPerintah2::with(
            'suratperintah',
            'suratperintah.dasar',
            'suratperintah.kepada',
            'suratperintah.tujuan',
            'suratperintah.untuk2', 
            'suratperintah.disampaikan', 
        )->find($id);

        return response()->json([
            'formatt' => $formatt,
        ]);
    }

    public function store_sp_2(Request $request)
    {
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke direktori server
            $gambar = $request->file('gambar');
            $gambarName = time() .'_'. $request->judul . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads'), $gambarName);
    
            $formatt = FormattSuratPerintah2::create([
                'gambar' => $gambarName,
                'judul' => $request->judul,
                'nama_lembaga' => $request->nama_lembaga,
                'alamat' => $request->alamat,
                'kota_pos' => $request->kota_pos,
                'an_nama' => $request->an_nama,
                'an_pangkat' => $request->an_pangkat,
                'an_nip' => $request->an_nip,
                'atas_nama' => $request->atas_nama,
                'pelaksanaan_tugas' => $request->pelaksanaan_tugas,
                'dikeluarkan_di' => $request->dikeluarkan_di,
            ]);
    
            return response()->json('Formatt Berhasil Di Buat');
        }
    
        return response()->json('Gagal menyimpan gambar.', 400);
    }

    public function update_sp_2(Request $request, $id)
    {
        $formatt = FormattSuratPerintah2::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() .'_'. $request->judul . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads'), $gambarName);

            if ($formatt->gambar) {
                unlink(public_path('uploads/' . $formatt->gambar));
            }

            $formatt->update([
                'gambar' => $gambarName,
                'judul' => $request->judul,
                'nama_lembaga' => $request->nama_lembaga,
                'alamat' => $request->alamat,
                'kota_pos' => $request->kota_pos,
                'an_nama' => $request->an_nama,
                'an_pangkat' => $request->an_pangkat,
                'an_nip' => $request->an_nip,
                'atas_nama' => $request->atas_nama,
                'pelaksanaan_tugas' => $request->pelaksanaan_tugas,
                'dikeluarkan_di' => $request->dikeluarkan_di,
            ]);
        } else {
            $formatt->update([
                'judul' => $request->judul,
                'nama_lembaga' => $request->nama_lembaga,
                'alamat' => $request->alamat,
                'kota_pos' => $request->kota_pos,
                'an_nama' => $request->an_nama,
                'an_pangkat' => $request->an_pangkat,
                'an_nip' => $request->an_nip,
                'atas_nama' => $request->atas_nama,
                'pelaksanaan_tugas' => $request->pelaksanaan_tugas,
                'dikeluarkan_di' => $request->dikeluarkan_di,
            ]);
        }

        return response()->json('Formatt Berhasil Di Perbarui');
    }

    public function delete_sp_2(Request $request, $id)
    {
        $formatt = FormattSuratPerintah2::findOrFail($id); 

        if ($formatt->gambar) {
            unlink(public_path('uploads/' . $formatt->gambar));
        }
        
        $formatt->delete();       

        return response()->json('Formatt Data Surat Berhasil Di Delete');
    }
}
