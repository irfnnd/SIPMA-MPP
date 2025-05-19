@extends('pengadu.layout')
@section('content')
<section id="pengaduan" class="contact section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="section-header text-center mb-5">
            <h2>Formulir Pengaduan Masyarakat</h2>
            <p class="text-muted">Silakan isi formulir berikut untuk menyampaikan pengaduan Anda terkait pelayanan publik.</p>
        </div>

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="php-email-form" data-aos="fade-up" data-aos-delay="500">
            @csrf
            <div class="row gy-4">

                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                <div class="col-md-12">
                    <label for="judul">Judul Pengaduan</label>
                    <input type="text" name="judul" class="form-control" placeholder="Judul Pengaduan" style="border-radius: 0; padding-inline: 15px; padding-block: 10px;" required>
                </div>

                <div class="col-md-12">
                    <label for="isi_laporan">Isi Laporan</label>
                    <textarea name="isi_laporan" class="form-control" rows="5" placeholder="Tuliskan detail pengaduan Anda di sini" style="border-radius: 0; padding-inline: 15px; padding-block: 10px;"required></textarea>
                </div>

                <div class="col-md-6">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" class="form-control" required style="border-radius: 0; padding-inline: 15px; padding-block: 10px;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="unit_id">Unit Pelayanan</label>
                    <select name="unit_id" class="form-control" required style="border-radius: 0; padding-inline: 15px; padding-block: 10px;">
                        <option value="">-- Pilih Unit Pelayanan --</option>
                        @foreach ($unit as $u)
                            <option value="{{ $u->id }}">{{ $u->nama_unit }} - {{ $u->keterangan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="lokasi">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" class="form-control" style="border-radius: 0; padding-inline: 15px; padding-block: 10px;" placeholder="Contoh: Kantor Pelayanan A">
                </div>

                <div class="col-md-12">
                    <label for="lampiran">Lampiran Foto (Opsional)</label>
                    <input type="file" name="lampiran" class="form-control" style="border-radius: 0; padding-inline: 15px; padding-block: 10px;">
                </div>

                <div class="col-md-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4">Kirim Pengaduan</button>
                </div>

            </div>
        </form>
    </div>
</section>
@endsection
