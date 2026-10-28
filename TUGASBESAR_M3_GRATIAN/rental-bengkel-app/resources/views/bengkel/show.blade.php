@extends('layouts.app')

@section('title', 'Detail Bengkel')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h1 class="h4 mb-0">{{ $bengkel->nama_bengkel }}</h1>
                    <span class="badge {{ $bengkel->status === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                        {{ $bengkel->status }}
                    </span>
                </div>

                <dl class="row mb-4">
                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8">{{ $bengkel->alamat }}</dd>

                    <dt class="col-sm-4">Kota</dt>
                    <dd class="col-sm-8">{{ $bengkel->kota }}</dd>

                    <dt class="col-sm-4">Nomor telepon</dt>
                    <dd class="col-sm-8">{{ $bengkel->nomor_telepon }}</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8">{{ $bengkel->email ?? '-' }}</dd>

                    <dt class="col-sm-4">Jenis layanan</dt>
                    <dd class="col-sm-8">{{ $bengkel->jenis_layanan }}</dd>

                    <dt class="col-sm-4">Dibuat pada</dt>
                    <dd class="col-sm-8">{{ $bengkel->created_at?->format('d M Y, H:i') }}</dd>
                </dl>

                <div class="d-flex gap-2">
                    <a href="{{ route('bengkel.edit', $bengkel) }}" class="btn btn-warning">Ubah</a>
                    <a href="{{ route('bengkel.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
