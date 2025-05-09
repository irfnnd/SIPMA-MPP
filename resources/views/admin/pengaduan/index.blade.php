@extends('admin.layout')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 text-primary">
                    <i class="fas fa-list-alt me-2"></i>Daftar pengaduan
                </h5>
            </div>
            <div class="card-body p-0">
                <!-- Search and filter section -->
                <div class="p-3 bg-light border-bottom">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <form id="searchForm" action="{{ route('pengaduan.index') }}" method="GET"
                                class="input-group">
                                <input type="text" id="searchInput" name="search" class="form-control"
                                    placeholder="Cari pengaduan..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>

                        <div class="col-md-6 text-md-end">
                            <span class="text-muted">Total:
                                <strong>{{ method_exists($pengaduans, 'total') ? $pengaduans->total() : $pengaduans->count() }}</strong>
                                pengaduan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Table section -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4" style="width: 50px">No</th>
                                <th>Judul</th>
                                <th>Nama Masyarakat</th>
                                {{-- <th>Unit Layanan</th>
                                <th>Kategori</th> --}}
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggapan</th>
                                <th class="text-center" style="width: 200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengaduans as $index => $pengaduan)
                                <tr>
                                    <td class="px-4">{{ $pengaduans->firstItem() + $index }}</td>
                                    <td>{{ $pengaduan->judul }}</td>
                                    <td>{{ $pengaduan->user->name ?? '-' }}</td>
                                    {{-- <td>{{ $pengaduan->unit->nama_unit ?? '-' }}</td> --}}
                                    {{-- <td>{{ $pengaduan->kategori->nama_kategori ?? '-' }}</td> --}}
                                    <td>{{ $pengaduan->lokasi ?? '-' }}</td>
                                    <td>
                                        <span
                                            class="badge
                                        {{ $pengaduan->status === 'menunggu'
                                            ? 'bg-warning text-dark'
                                            : ($pengaduan->status === 'Diproses'
                                                ? 'bg-info'
                                                : ($pengaduan->status === 'Selesai'
                                                    ? 'bg-success'
                                                    : 'bg-secondary')) }}">
                                            {{ ucfirst($pengaduan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if (!$pengaduan->tanggapan)
                                                <a type="button" class="btn btn-sm btn-primary text-white"
                                                    data-bs-toggle="modal" data-bs-target="#modalTanggapan">
                                                    <i class="fas fa-edit" data-bs-toggle="tooltip" title="Tanggapi"></i>
                                                </a>
                                            @else
                                                <div class="">
                                                    <strong>Telah ditanggapi</strong>
                                                </div>
                                            @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Tombol untuk membuka modal -->
                                            <a class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $pengaduan->id }}">
                                                <i class="fas fa-eye"data-bs-toggle="tooltip" title="Detail"></i>
                                            </a>
                                            @if($pengaduan->status != 'Selesai')
                                            <form action="{{ route('data-pengaduan.update', $pengaduan->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success text-white" data-bs-toggle="tooltip" title="Selesai">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif
                                            {{-- <form id="delete-form-{{ $pengaduan->id }}"
                                                action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete({{ $pengaduan->id }})" data-bs-toggle="tooltip"
                                                    title="Hapus pengaduan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form> --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                        Data tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" id="modalTanggapan" tabindex="-1" aria-labelledby="modalTanggapanLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('tanggapan.store', $pengaduans) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="modalTanggapanLabel">
                                    <i class="fas fa-reply me-2"></i>Beri Tanggapan
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label for="isi_tanggapan" class="form-label">Isi Tanggapan</label>
                                    <textarea name="isi_tanggapan" id="isi_tanggapan" class="form-control" rows="5" required placeholder="Tulis tanggapan Anda di sini..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i>Kirim Tanggapan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal -->
            @foreach($pengaduans as $pengaduan)
            <div class="modal fade" id="detailModal{{ $pengaduan->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $pengaduan->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
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
                                        style="width: {{ $pengaduan->status === 'Selesai' ? '100%' : ($pengaduan->status === 'Diproses' ? '50%' : '20%') }}"
                                        aria-valuenow="{{ $pengaduan->status === 'Selesai' ? '100' : ($pengaduan->status === 'Diproses' ? '50' : '20') }}"
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
                                                    <h6 class="mb-0">{{ $pengaduan->tanggapan->petugas->name ?? 'Petugas' }}</h6>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($pengaduan->tanggapan->created_at)->format('d M Y, H:i') }}</small>
                                                </div>
                                                <p class="mb-0 mt-2">{{ $pengaduan->tanggapan->isi_tanggapan }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-comment-slash fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada tanggapan untuk pengaduan ini</p>
                                            @if($pengaduan->status !== 'selesai')
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalTanggapan" data-bs-dismiss="modal">
                                                <i class="fas fa-comment-dots me-1"></i>Beri Tanggapan
                                            </button>
                                            @endif
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

            <!-- Footer section with pagination and per-page option -->
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <form method="GET" action="{{ route('pengaduan.index') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="perPage" class="form-select form-select-sm" style="width: auto;"
                            onchange="this.form.submit()">
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 per halaman
                            </option>
                            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25 per halaman
                            </option>
                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 per halaman
                            </option>
                        </select>
                    </form>
                    @if (method_exists($pengaduans, 'links'))
                        {{ $pengaduans->appends(request()->query())->links() }}
                    @else
                        <div class="text-muted"><small>Menampilkan semua data</small></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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
