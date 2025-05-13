@extends('layouts.main')

@section('content')
<div class="container-fluid">
    @include('components.flash-message')
<div class="container py-5">
  <div class="row g-4">

    <!-- Kartu Profil -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <img src="{{asset('template/assets/images/logo_icon.png')}}" class="mb-3" alt="Logo" style="width: 100px;">
          <h6 class="text-muted">Judul Website</h6>
          <h5>TSTH2 WHAREHOUSE</h5>
          <hr>
          <h6 class="text-muted">Deskripsi</h6>
          <p class="mb-0">SISTEM Management inventori TSTH2 WHAREHOUSE</p>
        </div>
      </div>
    </div>

    <!-- Form Pengaturan -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Ubah Pengaturan</h5>
          <div class="alert alert-primary p-2">
            <strong>Extensi Gambar</strong><br>
            .jpg .jpeg .png
          </div>
          <form>
            <div class="mb-3">
              <label for="logo" class="form-label">Logo</label>
              <input type="file" class="form-control" id="logo">
            </div>
            <div class="mb-3">l
              <label for="judul" class="form-label">Judul Website</label>
              <input type="text" class="form-control" id="judul" value="TSTH2 WHAREHOUSE">
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi Website</label>
              <textarea class="form-control" id="deskripsi" rows="3">Sistem Management inventori TSTH2 WHAREHOUSE</textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
@endsection
