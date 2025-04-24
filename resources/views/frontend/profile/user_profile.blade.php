@extends('frontend.profile.layout.template')
@section('contentprofile')
<!-- Right Side -->
<div class="col-md-12">
  <div class="profile-card p-4 card">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="text-muted  mb-0">Informasi Profil</h5>
    </div>
    <div class="row g-3 mb-3">
      <div class="col-md-12">
        <label class="form-label text-muted ">Nama</label>
        <input type="text" class="form-control" value="Carloka Dev" readonly>
      </div>
      <div class="col-md-12">
        <label class="form-label text-muted ">Email</label>
        <input type="email" class="form-control" value="carloka@email.com" readonly>
      </div>
      <div class="col-md-12">
        <label class="form-label text-muted ">Nomor Telepon</label>
        <input type="text" class="form-control" value="08123456789" readonly>
      </div>
    </div>
    <div class="text-end">
      <button class="btn btn-primary btn-flat" data-bs-toggle="modal" data-bs-target="#editInfoModal">
        <i class="bi bi-pencil-square me-1"></i> Edit Profil
      </button>
    </div>
  </div>
</div>

<!-- Modal Update Profile -->
<div class="modal fade" id="editInfoModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Edit Informasi Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nama" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" id="nama" name="nama" value="{{ session('user')['name'] }}">
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Alamat Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ session('user')['email'] }}">
            </div>
            <div class="col-md-6">
              <label for="no_telp" class="form-label">No. Telepon</label>
              <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ session('user')['no_telp'] ?? '' }}">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
