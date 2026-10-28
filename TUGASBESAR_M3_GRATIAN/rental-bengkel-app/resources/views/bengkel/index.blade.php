@extends('layouts.app')

@section('title', 'Daftar Bengkel')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h1 class="h4 mb-0">Daftar Bengkel Mitra</h1>
    <a href="{{ route('bengkel.create') }}" class="btn btn-primary">+ Tambah bengkel</a>
</div>

<form method="GET" action="{{ route('bengkel.index') }}" class="row g-2 mb-3">
    <div class="col-md-6">
        <input type="text" name="q" value="{{ $q }}" class="form-control"
               placeholder="Cari nama, kota, atau jenis layanan...">
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-secondary">Cari</button>
        @if ($q)
            <a href="{{ route('bengkel.index') }}" class="btn btn-link">Reset</a>
        @endif
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Bengkel</th>
                    <th>Kota</th>
                    <th>Telepon</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bengkels as $i => $b)
                    <tr>
                        <td>{{ $bengkels->firstItem() + $i }}</td>
                        <td>{{ $b->nama_bengkel }}</td>
                        <td>{{ $b->kota }}</td>
                        <td>{{ $b->nomor_telepon }}</td>
                        <td>{{ $b->jenis_layanan }}</td>
                        <td>
                            <span class="badge {{ $b->status === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ $b->status }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('bengkel.show', $b) }}" class="btn btn-sm btn-outline-info">Detail</a>
                            <a href="{{ route('bengkel.edit', $b) }}" class="btn btn-sm btn-outline-warning">Ubah</a>
                            <form action="{{ route('bengkel.destroy', $b) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus bengkel {{ $b->nama_bengkel }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data bengkel.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $bengkels->links() }}</div>
@endsection
