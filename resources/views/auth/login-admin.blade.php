<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="{{asset('assets/Admin/css/mdb.min.css')}}" rel="stylesheet" />
</head>
<body>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-4">
                <img src="{{ asset('assets/mpp-logo.png') }}" alt="Logo" style="max-width: 300px;">
            </div>
            <h5 class="">Sign in</h5>

            <form method="POST" action="{{ route('admin.login') }}">
              @csrf

              <div class="mb-4 text-start">
                <label class="form-label" for="email">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       autofocus>
                @error('email')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

              <div class=" mb-4 text-start">
                <label class="form-label" for="password">Password</label>
                <input type="password" style="border-radius: 6px;"
                       id="password"
                       name="password"
                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                       required
                       autocomplete="current-password">
                @error('password')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-check d-flex justify-content-start mb-4">
                <input style="border-radius: 6px;" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label ms-2" for="remember">Remember me</label>
              </div>

              <hr class="mb-4">

              <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
