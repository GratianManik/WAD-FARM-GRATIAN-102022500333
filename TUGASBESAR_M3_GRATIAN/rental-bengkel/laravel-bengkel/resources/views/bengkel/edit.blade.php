@extends('layouts.app')

@section('title', 'Ubah Bengkel')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-4">Ubah bengkel</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">Periksa kembali isian yang ditandai merah.</div>
                @endif

                <form action="{{ route('bengkel.update', $bengkel) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    @include('bengkel._form', ['teksTombol' => 'Simpan perubahan'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
