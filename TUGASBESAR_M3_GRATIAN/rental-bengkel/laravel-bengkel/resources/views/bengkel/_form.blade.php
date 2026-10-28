@php
    $b = $bengkel ?? null;
@endphp

<div class="mb-3">
    <label for="nama_bengkel" class="form-label">Nama bengkel *</label>
    <input type="text" id="nama_bengkel" name="nama_bengkel" maxlength="100"
           class="form-control @error('nama_bengkel') is-invalid @enderror"
           value="{{ old('nama_bengkel', $b->nama_bengkel ?? '') }}">
    @error('nama_bengkel') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="alamat" class="form-label">Alamat *</label>
    <textarea id="alamat" name="alamat" rows="3"
              class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $b->alamat ?? '') }}</textarea>
    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="kota" class="form-label">Kota *</label>
        <input type="text" id="kota" name="kota" maxlength="100"
               class="form-control @error('kota') is-invalid @enderror"
               value="{{ old('kota', $b->kota ?? '') }}">
        @error('kota') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="nomor_telepon" class="form-label">Nomor telepon *</label>
        <input type="tel" id="nomor_telepon" name="nomor_telepon" maxlength="20"
               class="form-control @error('nomor_telepon') is-invalid @enderror"
               value="{{ old('nomor_telepon', $b->nomor_telepon ?? '') }}">
        @error('nomor_telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email (opsional)</label>
    <input type="email" id="email" name="email" maxlength="100"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $b->email ?? '') }}">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="jenis_layanan" class="form-label">Jenis layanan *</label>
        <select id="jenis_layanan" name="jenis_layanan"
                class="form-select @error('jenis_layanan') is-invalid @enderror">
            <option value="">Pilih layanan</option>
            @foreach (\App\Models\Bengkel::DAFTAR_LAYANAN as $layanan)
                <option value="{{ $layanan }}"
                    @selected(old('jenis_layanan', $b->jenis_layanan ?? '') === $layanan)>
                    {{ $layanan }}
                </option>
            @endforeach
        </select>
        @error('jenis_layanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Status bengkel *</label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
            @foreach (\App\Models\Bengkel::DAFTAR_STATUS as $st)
                <option value="{{ $st }}" @selected(old('status', $b->status ?? 'Aktif') === $st)>
                    {{ $st }}
                </option>
            @endforeach
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">{{ $teksTombol }}</button>
    <a href="{{ route('bengkel.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>
