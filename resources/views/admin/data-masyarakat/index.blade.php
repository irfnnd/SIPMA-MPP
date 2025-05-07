@extends('admin.layout')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 text-primary">
                    <i class="fas fa-list-alt me-2"></i>Daftar masyarakat
                </h5>
                <a href="{{ route('data-masyarakat.create') }}" class="btn btn-primary">
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
                                    <td>{{ $user->no_hp ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('data-masyarakat.show', $user->id) }}" class="btn btn-sm btn-primary"
                                            data-bs-toggle="tooltip" title="Lihat detail">
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

            <!-- Footer section with pagination and per-page option -->
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <form method="GET" action="{{ route('data-masyarakat.index') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="perPage" class="form-select form-select-sm" style="width: auto;"
                            onchange="this.form.submit()">
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10 per halaman</option>
                            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25 per halaman</option>
                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50 per halaman</option>
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
