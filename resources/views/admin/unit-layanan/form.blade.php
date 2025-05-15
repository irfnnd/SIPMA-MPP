@extends('admin.layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $unit->exists ? 'Edit unit' : 'Tambah unit Baru' }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ $unit->exists ? route('unit.update', $unit) : route('unit.store') }}" method="POST">
                        @csrf
                        @if($unit->exists)
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="nama_unit" class="form-label fw-bold">Nama unit</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input
                                    type="text"
                                    name="nama_unit"
                                    id="nama_unit"
                                    class="form-control @error('nama_unit') is-invalid @enderror"
                                    value="{{ old('nama_unit', $unit->nama_unit) }}"
                                    placeholder="Masukkan nama unit"
                                    required
                                    autofocus>
                            </div>
                            @error('nama_unit')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                            <div class="input-group">
                                <textarea name="keterangan" id="keterangan" class="form-control" style="height: 100px">{{ old('keterangan', $unit->keterangan) }}</textarea>
                            </div>
                            @error('keterangan')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('unit.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-{{ $unit->exists ? 'save' : 'plus-circle' }} me-1"></i>
                                {{ $unit->exists ? 'Simpan' : 'Tambah' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
