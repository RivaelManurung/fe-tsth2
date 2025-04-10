@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Data Barang</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateBarang">
                <i class="icon-database-add me-2"></i> Tambah Barang
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle datatable-button-html5-basic">
                <thead class="table-dark">
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
                    @if (!empty($barangs) && is_iterable($barangs))
                        @foreach ($barangs as $key => $barang)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $barang['barang_nama'] ?? '-' }}</td>
                                <td>{{ $barang['barang_kode'] ?? '-' }}</td>
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
                                        $qrCodeBaseUrl = rtrim(config('api.qr_code'), '/') . '/qr_code/';
                                        $qrCodeFormats = ['png', 'jpg', 'jpeg'];
                                        $qrCodeUrl = null;

                                        foreach ($qrCodeFormats as $format) {
                                            $tempUrl = $qrCodeBaseUrl . $barang['barang_kode'] . '.' . $format;
                                            $headers = @get_headers($tempUrl);
                                            if ($headers && strpos($headers[0], '200')) {
                                                $qrCodeUrl = $tempUrl;
                                                break;
                                            }
                                        }
                                    @endphp

                                    @if ($qrCodeUrl)
                                        <img src="{{ $qrCodeUrl }}" width="50"
                                            alt="QR Code {{ $barang['barang_kode'] }}">
                                    @else
                                        <span class="text-muted">Tidak tersedia</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-link btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailBarang{{ $barang['id'] }}" title="Detail">
                                            <i class="ph-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-link btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#updateBarang{{ $barang['id'] }}" title="Edit">
                                            <i class="ph-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-link text-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteBarang{{ $barang['id'] }}" title="Hapus">
                                            <i class="ph-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-muted">Data barang belum tersedia.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- @include('frontend.barang.create-modal') --}}

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
                                    $qrCodeBaseUrl = rtrim(config('api.qr_code'), '/') . '/qr_code/';
                                    $qrCodeFormats = ['png', 'jpg', 'jpeg'];
                                    $qrCodeUrl = null;

                                    foreach ($qrCodeFormats as $format) {
                                        $tempUrl = $qrCodeBaseUrl . $barang['barang_kode'] . '.' . $format;

                                        // Cek apakah file tersedia tanpa melempar error
                                        $headers = @get_headers($tempUrl);
                                        if ($headers && strpos($headers[0], '200')) {
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
                            <div class="col-md-4 fw-bold">Satuan:</div>
                            <div class="col-md-8">{{ $barang['satuan'] ?? '-' }}</div>
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
        <div class="modal fade" id="updateBarang{{ $barang['id'] }}" tabindex="-1" aria-hidden="true">
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

                            <!-- Dropdown Kategori -->
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="barangcategory_id" class="form-select">
                                    @foreach ($kategori_barangs as $category)
                                        <option value="{{ $category['id'] }}"
                                            {{ $barang['barangcategory_id'] == $category['id'] ? 'selected' : '' }}>
                                            {{ $category['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Jenis Barang -->
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang</label>
                                <select name="jenisbarang_id" class="form-select">
                                    @foreach ($jenis_barangs as $jenis)
                                        <option value="{{ $jenis['id'] }}"
                                            {{ isset($barang['jenisBarang']) && ((is_array($barang['jenisBarang']) && $barang['jenisBarang']['id'] == $jenis['id']) || $barang['jenisBarang'] == $jenis['name']) ? 'selected' : '' }}>
                                            {{ $jenis['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dropdown Satuan -->
                            <div class="mb-3">
                                <label class="form-label">Satuan</label>
                                <select name="satuan_id" class="form-select">
                                    @foreach ($satuans as $satuan)
                                        <option value="{{ $satuan['id'] }}"
                                            {{ isset($barang['satuan']) && ((is_array($barang['satuan']) && $barang['satuan']['id'] == $satuan['id']) || $barang['satuan'] == $satuan['name']) ? 'selected' : '' }}>
                                            {{ $satuan['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Upload Gambar -->
                            <div class="mb-3">
                                <label class="form-label">Gambar Barang</label>
                                <input type="file" name="barang_gambar" class="form-control">
                                @if (!empty($barang['barang_gambar']))
                                    <img src="{{ $barang['barang_gambar'] }}" class="img-thumbnail mt-2"
                                        style="max-width: 150px; max-height: 150px;" alt="Gambar Barang">
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
        </div>


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
