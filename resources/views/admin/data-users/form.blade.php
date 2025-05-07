@extends('admin.layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $kategori->exists ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ $kategori->exists ? route('kategori.update', $kategori) : route('kategori.store') }}" method="POST">
                        @csrf
                        @if($kategori->exists)
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-bold">Nama Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input
                                    type="text"
                                    name="nama_kategori"
                                    id="nama_kategori"
                                    class="form-control @error('nama_kategori') is-invalid @enderror"
                                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                    placeholder="Masukkan nama kategori"
                                    required
                                    autofocus>
                            </div>
                            @error('nama_kategori')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-{{ $kategori->exists ? 'save' : 'plus-circle' }} me-1"></i>
                                {{ $kategori->exists ? 'Simpan' : 'Tambah' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
