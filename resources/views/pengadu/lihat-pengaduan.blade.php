@extends('pengadu.layout')
@section('content')
<section id="pengaduan" class="contact section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="section-header text-center mb-5">
            <h2>Daftar Pengaduan Saya</h2>
            <p class="text-muted">Berikut adalah daftar pengaduan yang telah Anda kirimkan.</p>
        </div>

        <div class="table-responsive">
            <table class="table ttable-sm table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 50px">No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="width: 150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $index => $item)
                        <tr>
                            <td class="text-center">{{ $pengaduans->firstItem() + $index }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                            <td class="text-center">
                                @if ($item->status === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($item->status === 'proses')
                                    <span class="badge bg-primary">Diproses</span>
                                @elseif ($item->status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">Tidak diketahui</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pengaduan.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                Belum ada pengaduan yang Anda kirimkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pengaduans->links() }}
        </div>

    </div>
</section>
@endsection
