@extends('admin.layout')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 text-primary">
                    <i class="fas fa-list-alt me-2"></i>Daftar masyarakat
                </h5>
                <a href="{{ route('data-pengguna.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i>Tambah masyarakat
                </a>
            </div>
            <div class="card-body p-0">
                <!-- Search and filter section -->
                <div class="p-3 bg-light border-bottom">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <form id="searchForm" action="{{ route('data-masyarakat.index') }}" method="GET"
                                class="input-group">
                                <input type="text" id="searchInput" name="search" class="form-control"
                                    placeholder="Cari masyarakat..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="text-muted">Total:
                                <strong>{{ method_exists($masyarakats, 'total') ? $masyarakats->total() : $masyarakats->count() }}</strong>
                                masyarakat
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th class="text-center" style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($masyarakats as $index => $user)
                                <tr>
                                    <td class="px-4">{{ $masyarakats->firstItem() + $index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $user->id }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('data-masyarakat.destroy', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete({{ $user->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-user-times fa-2x mb-3 d-block"></i>
                                        Data masyarakat tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @foreach ($masyarakats as $user)
                <div class="modal fade" id="detailModal{{ $user->id }}" tabindex="-1"
                    aria-labelledby="modalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalLabel{{ $user->id }}">
                                    <i class="fas fa-info-circle me-2"></i>Detail Pengguna
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="text-muted small">Nama Pengguna</div>
                                            <h5>{{ $user->name }}</h5>
                                        </div>
                                        <div class="mb-3">
                                            <div class="text-muted small">Email</div>
                                            <div>{{ $user->email }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="text-muted small">No. HP</div>
                                            <div>{{ $user->phone ?? '-' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="text-muted small">Role</div>
                                            <div>{{ $user->role ?? '-' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="text-muted small">Tanggal Bergabung</div>
                                            <div>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y, H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="text-muted small">Status Akun</div>
                                            <div>{{ $user->status ?? 'Aktif' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="text-muted small">Jumlah Pengaduan</div>
                                            <div>{{ $user->pengaduans->count() }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pengaduan</h6>
                                    </div>
                                    <div class="card-body">
                                        @forelse ($user->pengaduans as $pengaduan)
                                            <div class="d-flex mb-3">
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0">{{ $pengaduan->judul ?? '-' }}</h6>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y, H:i') ?? '-' }}
                                                        </small>
                                                    </div>
                                                    <p class="mb-0 mt-2">
                                                        {{ $pengaduan->isi_laporan ?? 'Belum ada pengaduan' }}</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="d-flex mb-3">
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0">-</h6>
                                                        <small class="text-muted">-</small>
                                                    </div>
                                                    <p class="mb-0 mt-2">Belum ada pengaduan</p>
                                                </div>
                                            </div>
                                        @endforelse

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
                    <form method="GET" action="{{ route('data-masyarakat.index') }}">
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
                    @if (method_exists($masyarakats, 'links'))
                        {{ $masyarakats->appends(request()->query())->links() }}
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
