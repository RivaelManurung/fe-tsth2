@extends('layouts.main')

@section('content')
   <button type="button" class="btn btn-primary btn-labeled btn-labeled-start mb-2" data-bs-toggle="modal"
            data-bs-target="#modal_centered">
            <span class="btn-labeled-icon bg-black bg-opacity-20">
                <i class="icon-database-add"></i>
            </span> Tambah
        </button>


        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Table barang</h5>
            </div>
            <table class="table datatable-button-html5-basic">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kode</th>
                        <th>Gambar Barang</th>
                        <th>QR Code</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $key => $barang)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $barang['barang_nama'] }}</td>
                            <td>{{ $barang['barang_kode'] }}</td>
                            <td>
                                @if (!empty($barang['barang_gambar']))
                                    <img src="{{ $barang['barang_gambar'] }}" class="img-thumbnail" width="100"
                                        alt="Gambar Barang">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>

                            <td>
                                @php
                                    $qrCodeBaseUrl = 'http://127.0.0.1:8090/storage/qr_code/';
                                    $qrCodeFormats = ['png', 'jpg', 'jpeg'];
                                    $qrCodeUrl = null;
                                    foreach ($qrCodeFormats as $format) {
                                        $tempUrl = $qrCodeBaseUrl . $barang['barang_kode'] . '.' . $format;
                                        if (@getimagesize($tempUrl)) {
                                            // Cek apakah file valid
                                            $qrCodeUrl = $tempUrl;
                                            break;
                                        }
                                    }
                                @endphp
                                @if ($qrCodeUrl)
                                    <img src="{{ $qrCodeUrl }}" width="50" alt="QR Code">
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <!-- Show -->
                                    <a href="#" class="text-info me-2" data-bs-toggle="modal"
                                        data-bs-target="#detailBarang{{ $barang['id'] }}" title="Detail">
                                        <i class="ph-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="#" class="text-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#updateBarang{{ $barang['id'] }}" title="Edit">
                                        <i class="ph-pencil"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('barangs.destroy', $barang['id']) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')" class="d-inline me-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 text-danger" title="Hapus">
                                            <i class="ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @foreach ($barangs as $barang)
        <!-- Modal View Barang -->
        <div class="modal fade" id="detailBarang{{ $barang['id'] }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Bagian Gambar Barang dan QR Code -->
                        <div class="row mb-3">
                            <div class="col-md-6 text-center">
                                <p class="fw-bold">Gambar Barang</p>
                                @if (!empty($barang['barang_gambar']))
                                    <img src="{{ $barang['barang_gambar'] }}" class="img-fluid img-thumbnail"
                                        style="max-width: 200px; max-height: 200px;" alt="Gambar Barang">
                                @else
                                    <p class="text-muted">Tidak ada gambar</p>
                                @endif
                            </div>
                            <div class="col-md-6 text-center">
                                <p class="fw-bold">QR Code</p>
                                @php
                                    $qrCodeBaseUrl = 'http://127.0.0.1:8090/storage/qr_code/';
                                    $qrCodeFormats = ['png', 'jpg', 'jpeg'];
                                    $qrCodeUrl = null;
                                    foreach ($qrCodeFormats as $format) {
                                        $tempUrl = $qrCodeBaseUrl . $barang['barang_kode'] . '.' . $format;
                                        if (@getimagesize($tempUrl)) {
                                            $qrCodeUrl = $tempUrl;
                                            break;
                                        }
                                    }
                                @endphp
                                @if ($qrCodeUrl)
                                    <img src="{{ $qrCodeUrl }}" class="img-fluid img-thumbnail"
                                        style="max-width: 200px; max-height: 200px;" alt="QR Code">
                                @else
                                    <p class="text-muted">Tidak tersedia</p>
                                @endif
                            </div>
                        </div>

                        <!-- Bagian Detail Barang -->
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Kode Barang:</div>
                            <div class="col-md-8">{{ $barang['barang_kode'] }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Nama Barang:</div>
                            <div class="col-md-8">{{ $barang['barang_nama'] }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Harga:</div>
                            <div class="col-md-8">Rp {{ number_format($barang['barang_harga'], 0, ',', '.') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Kategori:</div>
                            <div class="col-md-8">{{ $barang['category'] ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Jenis Barang:</div>
                            <div class="col-md-8">{{ $barang['jenisBarang'] ?? '-' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">barang:</div>
                            <div class="col-md-8">{{ $barang['barang'] ?? '-' }}</div>
                        </div>

                        <!-- Bagian Gudang -->
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Gudang:</div>
                            <div class="col-md-8">
                                @if (count($barang['gudangs']) > 0)
                                    <ul class="list-group">
                                        @foreach ($barang['gudangs'] as $gudang)
                                            <li class="list-group-item">
                                                <strong>{{ $gudang['name'] }}</strong> - Stok Tersedia:
                                                {{ $gudang['stok_tersedia'] }}
                                                - Dipinjam: {{ $gudang['stok_dipinjam'] }} - Maintenance:
                                                {{ $gudang['stok_maintenance'] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Tidak ada gudang</span>
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

        <!-- Modal Update Barang -->
        <!-- Modal Update Barang -->
        {{-- <div class="modal fade" id="updateBarang{{ $barang['id'] }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('barangs.update', $barang['id']) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="barang_nama" class="form-control"
                                    value="{{ $barang['barang_nama'] }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="barang_harga" class="form-control"
                                    value="{{ $barang['barang_harga'] }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="barangcategory_id" class="form-select">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}"
                                            {{ isset($barang['category']) && $barang['category']['id'] == $category['id'] ? 'selected' : '' }}>
                                            {{ $category['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang</label>
                                <select name="jenisbarang_id" class="form-select">
                                    @foreach ($jenisbarangs as $jenis)
                                        <option value="{{ $jenis['id'] }}"
                                            {{ isset($barang['jenisBarang']) && $barang['jenisBarang']['id'] == $jenis['id'] ? 'selected' : '' }}>
                                            {{ $jenis['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">barang</label>
                                <select name="barang_id" class="form-select">
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang['id'] }}"
                                            {{ isset($barang['barang']) && $barang['barang']['id'] == $barang['id'] ? 'selected' : '' }}>
                                            {{ $barang['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar Barang</label>
                                <input type="file" name="barang_gambar" class="form-control">
                                @if (!empty($barang['barang_gambar']))
                                    <img src="{{ $barang['barang_gambar'] }}" class="img-thumbnail mt-2"
                                        style="max-width: 150px; max-height: 150px;">
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}


        <!-- Modal Delete Barang -->
        <div class="modal fade" id="deleteBarang{{ $barang['id'] }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus <strong>{{ $barang['barang_nama'] }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('barangs.destroy', $barang['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
