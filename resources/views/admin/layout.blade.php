<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{asset('assets/mpp-icon.png')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="{{ asset('assets/Admin/css/admin.css') }}" />
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('assets/Admin/css/mdb.min.css') }}" />
    <!-- Bootstrap 5 JS (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
        integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!--Main Navigation-->
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action py-2 {{ Request::is('admin/dashboard') || Request::is('admin/') ? 'active' : '' }} "
                        style="border-radius: 4px" data-mdb-ripple-init aria-current="true">
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
                    </a>
                    <a href="{{ route('kategori.index') }}" class="list-group-item list-group-item-action py-2 {{ Request::is('admin/kategori') ? 'active' : '' }}" data-mdb-ripple-init>
                        <i class="fas fa-tag fa-fw me-3"></i><span>Kategori</span>
                    </a>
                    <a href="{{ route('unit.index') }}" class="list-group-item list-group-item-action py-2 {{ Request::is('admin/unit') ? 'active' : '' }}" data-mdb-ripple-init>
                        <i class="fas fa-building fa-fw me-3"></i><span>Unit Layanan</span>
                    </a>
                    <a href="{{ route('data-pengaduan.index') }}" class="list-group-item list-group-item-action py-2 {{ Request::is('admin/data-pengaduan') ? 'active' : '' }}" data-mdb-ripple-init>
                        <i class="fas fa-comment-dots fa-fw me-3"></i><span>Data Pengaduan</span>
                    </a>
            <a href="{{ route('data-masyarakat.index') }}" class="list-group-item list-group-item-action py-2 {{ Request::is('admin/data-masyarakat') ? 'active' : '' }}" data-mdb-ripple-init>
                        <i class="fas fa-users fa-fw me-3"></i><span>Data Masyarakat</span>
                    </a>
                    @can('viewAny', App\Models\User::class)
                    <a href="{{ route('data-petugas.index') }}" class="list-group-item list-group-item-action py-2 {{ Request::is('admin/data-petugas') ? 'active' : '' }}" data-mdb-ripple-init>
                        <i class="fas fa-user-shield fa-fw me-3"></i><span>Data Petugas</span>
                    </a>
                    @endcan
                    @can('viewAny', App\Models\User::class)
                    <a href="{{ route('data-pengguna.index') }}" class="list-group-item list-group-item-action py-2 {{ Request::is('admin/data-pengguna') ? 'active' : '' }}" data-mdb-ripple-init>
                        <i class="fas fa-user-cog fa-fw me-3"></i><span>Users</span>
                    </a>
                    @endcan
                </div>
            </div>
        </nav>
        <!-- Sidebar -->

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-collapse-init data-mdb-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Brand -->
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/mpp-logo.png') }}" class="ms-4" height="40" alt="" loading="lazy" />
                </a>

                <!-- Right links -->
                <ul class="navbar-nav ms-auto d-flex flex-row">

                    <!-- Avatar -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
                            id="navbarDropdownMenuLink" role="button" data-mdb-dropdown-init aria-expanded="false">
                            <img src="{{ asset('assets/avatar.png') }}" class="rounded-circle"
                                height="40" alt="" loading="lazy" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li class="dropdown-item bg-primary text-white text-center border-bottom-3"><img src="{{ asset('assets/avatar.png') }}" class="rounded-circle"
                                height="40" alt="" loading="lazy" /> {{Auth::user()->name}}</li>
                            <li><a class="dropdown-item" href="{{route('admin.logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main style="margin-top: 58px">
        <div class="container pt-4">
            @yield('content')
        </div>
    </main>

    <!--Main layout-->
    <!-- MDB -->
    <script type="text/javascript" src="{{asset('assets/Admin/js/mdb.umd.min.js')}}"></script>
    <!-- Custom scripts -->
    <script type="text/javascript" src="{{asset('assets/Admin/js/admin.js')}}"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.form-selesai').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Cegah submit langsung

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data pengaduan akan ditandai sebagai selesai!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Selesaikan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form jika dikonfirmasi
                    }
                });
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</body>

</html>
