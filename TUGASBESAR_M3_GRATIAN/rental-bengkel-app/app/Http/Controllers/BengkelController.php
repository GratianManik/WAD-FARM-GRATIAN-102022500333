<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BengkelController extends Controller
{
    // READ: daftar bengkel + pencarian + pagination
    public function index(Request $request)
    {
        $q = $request->query('q');

        $bengkels = Bengkel::query()
            ->when($q, function ($query) use ($q) {
                $query->where('nama_bengkel', 'like', "%{$q}%")
                      ->orWhere('kota', 'like', "%{$q}%")
                      ->orWhere('jenis_layanan', 'like', "%{$q}%");
            })
            ->latest('id_bengkel')
            ->paginate(10)
            ->withQueryString();

        return view('bengkel.index', compact('bengkels', 'q'));
    }

    // CREATE: tampilkan form
    public function create()
    {
        return view('bengkel.create');
    }

    // CREATE: simpan data
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        Bengkel::create($data);

        return redirect()->route('bengkel.index')
            ->with('sukses', "Bengkel \"{$data['nama_bengkel']}\" berhasil ditambahkan.");
    }

    // READ: detail satu bengkel
    public function show(Bengkel $bengkel)
    {
        return view('bengkel.show', compact('bengkel'));
    }

    // UPDATE: tampilkan form edit
    public function edit(Bengkel $bengkel)
    {
        return view('bengkel.edit', compact ('bengkel'));
    }

    // UPDATE: simpan perubahan
    public function update(Request $request, Bengkel $bengkel)
    {
        $data = $request->validate($this->rules(), $this->messages());

        $bengkel->update($data);

        return redirect()->route('bengkel.index')
            ->with('sukses', "Data bengkel \"{$bengkel->nama_bengkel}\" berhasil diperbarui.");
    }

    // DELETE
    public function destroy(Bengkel $bengkel)
    {
        $nama = $bengkel->nama_bengkel;
        $bengkel->delete();

        return redirect()->route('bengkel.index')
            ->with('sukses', "Bengkel \"{$nama}\" berhasil dihapus.");
    }

    private function rules(): array
    {
        return [
            'nama_bengkel'  => ['required', 'string', 'max:100'],
            'alamat'        => ['required', 'string'],
            'kota'          => ['required', 'string', 'max:100'],
            'nomor_telepon' => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'email'         => ['nullable', 'email', 'max:100'],
            'jenis_layanan' => ['required', Rule::in(Bengkel::DAFTAR_LAYANAN)],
            'status'        => ['required', Rule::in(Bengkel::DAFTAR_STATUS)],
        ];
    }

    private function messages(): array
    {
        return [
            'required'            => ':attribute wajib diisi.',
            'max'                 => ':attribute maksimal :max karakter.',
            'email'               => 'Format email tidak valid.',
            'in'                  => ':attribute tidak valid.',
            'nomor_telepon.regex' => 'Nomor telepon harus 8-20 karakter: angka, +, - atau spasi.',
        ];
    }
}
