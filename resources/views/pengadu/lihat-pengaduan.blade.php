@extends('pengadu.layout')

@section('content')
<div class="container py-4" data-aos="fade-up" data-aos-delay="100">
    <!-- Header Card -->
    <div class="card shadow-sm rounded-3 border-0 mb-4">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>Daftar Pengaduan
                </h4>
                <span class="badge bg-white text-primary fs-6 px-3 py-2 rounded-pill">
                    <i class="fas fa-list-alt me-1"></i>
                    {{ method_exists($pengaduans, 'total') ? $pengaduans->total() : $pengaduans->count() }}
                </span>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="card-body p-4">
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <form id="searchForm" action="{{ route('pengaduan.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Cari pengaduan berdasarkan judul, nama, atau lokasi..."
                                value="{{ request('search') }}">
                            <button class="btn btn-light" type="submit">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end">
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="statusFilter" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i> Status
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="statusFilter">
                                <li><a class="dropdown-item" href="#">Semua</a></li>
                                <li><a class="dropdown-item" href="#">Menunggu</a></li>
                                <li><a class="dropdown-item" href="#">Diproses</a></li>
                                <li><a class="dropdown-item" href="#">Selesai</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortOrder" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-sort me-1"></i> Urutkan
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="sortOrder">
                                <li><a class="dropdown-item" href="#">Terbaru</a></li>
                                <li><a class="dropdown-item" href="#">Terlama</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 50px">No</th>
                        <th class="py-3">Judul</th>
                        <th class="py-3">Nama Masyarakat</th>
                        <th class="py-3">Lokasi</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Tanggapan</th>
                        <th class="text-center py-3" style="width: 120px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $index => $pengaduan)
                    <tr>
                        <td class="px-4">{{ $pengaduans->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-bold text-primary">{{ $pengaduan->judul }}</div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y') }}</small>
                        </td>
                        <td>{{ $pengaduan->user->name ?? '-' }}</td>
                        <td>{{ $pengaduan->lokasi ?? '-' }}</td>
                        <td>
                            <span class="badge rounded-pill
                                {{ $pengaduan->status === 'menunggu' ? 'bg-warning text-dark' :
                                   ($pengaduan->status === 'diproses' ? 'bg-info' :
                                   ($pengaduan->status === 'selesai' ? 'bg-success' : 'bg-secondary')) }}
                                px-3 py-2">
                                <i class="fas
                                    {{ $pengaduan->status === 'menunggu' ? 'fa-clock' :
                                       ($pengaduan->status === 'diproses' ? 'fa-spinner fa-spin' :
                                       ($pengaduan->status === 'selesai' ? 'fa-check-circle' : 'fa-question-circle')) }}
                                    me-1"></i>
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </td>
                        <td>
                            @if (!$pengaduan->tanggapan)
                            <span class="text-muted fst-italic">
                                <i class="fas fa-comment-slash me-1"></i>
                                Belum ada tanggapan
                            </span>
                            @else
                            <div class="d-flex align-items-start">
                                <i class="fas fa-comment-dots text-success me-2 mt-1"></i>
                                <div>
                                    <div class="text-truncate" style="max-width: 200px;">
                                        {{ $pengaduan->tanggapan->isi_tanggapan }}
                                    </div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($pengaduan->tanggapan->created_at)->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pengaduan->id }}" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Data Tidak Ditemukan</h5>
                                <p class="text-muted">Belum ada pengaduan yang tersedia atau sesuai dengan pencarian Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('pengaduan.index') }}" class="d-flex align-items-center">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label for="perPage" class="me-2 text-muted">Tampilkan:</label>
                    <select name="perPage" id="perPage" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <div>
                    @if (method_exists($pengaduans, 'links'))
                    <nav aria-label="Page navigation">
                        {{ $pengaduans->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </nav>
                    @else
                    <div class="text-muted"><small>Menampilkan semua data</small></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    @foreach($pengaduans as $pengaduan)
    <div class="modal fade " id="detailModal{{ $pengaduan->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $pengaduan->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light ">
                    <h5 class="modal-title" id="modalLabel{{ $pengaduan->id }}">
                        <i class="fas fa-info-circle me-2"></i>Detail Pengaduan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="text-muted small">Judul Pengaduan</div>
                                <h5>{{ $pengaduan->judul }}</h5>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Nama Pelapor</div>
                                <div>{{ $pengaduan->user->name ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Tanggal Dilaporkan</div>
                                <div>{{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="text-muted small">Kategori</div>
                                <div>{{ $pengaduan->kategori->nama_kategori ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Unit</div>
                                <div>{{ $pengaduan->unit->nama_unit ?? '-' }}</div>
                            </div>
                            <div class="mb-3">
                                <div class="text-muted small">Lokasi</div>
                                <div>{{ $pengaduan->lokasi }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="text-muted small mb-2">Status Pengaduan</div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $pengaduan->status === 'selesai' ? '100%' : ($pengaduan->status === 'diproses' ? '50%' : '20%') }}"
                                aria-valuenow="{{ $pengaduan->status === 'selesai' ? '100' : ($pengaduan->status === 'diproses' ? '50' : '20') }}"
                                aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="badge {{ $pengaduan->status === 'menunggu' ? 'bg-warning text-dark' : 'bg-light text-muted' }}">Menunggu</span>
                            <span class="badge {{ $pengaduan->status === 'diproses' ? 'bg-info' : 'bg-light text-muted' }}">Diproses</span>
                            <span class="badge {{ $pengaduan->status === 'selesai' ? 'bg-success' : 'bg-light text-muted' }}">Selesai</span>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-comment-alt me-2"></i>Isi Laporan</h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $pengaduan->isi_laporan }}</p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-reply me-2"></i>Tanggapan</h6>
                        </div>
                        <div class="card-body">
                            @if ($pengaduan->tanggapan)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="avatar bg-primary text-white rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Petugas</h6>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($pengaduan->tanggapan->created_at)->format('d M Y, H:i') }}</small>
                                        </div>
                                        <p class="mb-0 mt-2">{{ $pengaduan->tanggapan->isi_tanggapan }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-comment-slash fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada tanggapan untuk pengaduan ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>

<style>
    /* Custom styles */
    .bg-gradient-primary {
        background: #ffffff;
    }

    .table th {
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }

    .dropdown-menu {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltip Bootstrap
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function(el) {
            return new bootstrap.Tooltip(el)
        });

        // Client-side live search
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const input = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? '' : 'none';
            });
        });
    });
</script>
@endsection
