@extends('frontend.profile.layout.template')

@section('contentprofile')
<!-- Right Side -->
<div class="col-md-12">
  <div class="profile-card p-4 card">
    <h5 class="mb-4 fw-semibold text-muted">Ganti Password</h5>
    <form method="POST">
      @csrf
      <div class="row g-3 mb-3">
        <div class="col-12">
          <label for="current_password form-label" class="form-label text-muted">Password Lama</label>
          <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan password lama" required>
        </div>
        <div class="col-12">
          <label for="new_password" class="form-label text-muted">Password Baru</label>
          <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password baru" required>
        </div>
        <div class="col-12">
          <label for="confirm_password" class="form-label text-muted">Konfirmasi Password Baru</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password baru" required>
        </div>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-key me-1"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
