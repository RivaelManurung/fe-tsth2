@extends('layouts.main')

@section('content')
    @include('components.flash-message')

    <div class="d-flex justify-content-between mb-3">
        <h4></h4>
        <div>
            <a href="{{ route('barang.refresh-qrcodes') }}" class="btn btn-secondary btn-labeled btn-labeled-start mb-2 me-2">
                <span class="btn-labeled-icon bg-black bg-opacity-20">
                    <i class="icon-sync"></i>
                </span> Refresh QR Code
            </a>
            <button type="button" class="btn btn-primary btn-labeled btn-labeled-start mb-2" data-bs-toggle="modal"
                data-bs-target="#modalCreateBarang">
                <span class="btn-labeled-icon bg-black bg-opacity-20">
                    <i class="icon-database-add"></i>
                </span> Tambah Barang
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Table Barang</h5>
        </div>

        <div class="table-responsive">
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
                    @forelse ($barangs as $key => $barang)
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
                            <td>
                                <div class="d-inline-flex">
                                    <a href="#" class="text-info me-2" data-bs-toggle="modal"
                                        data-bs-target="#detailBarang{{ $barang['id'] }}" title="Detail">
                                        <i class="ph-eye"></i>
                                    </a>
                                    <a href="#" class="text-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#updateBarangModal  {{ $barang['id'] }}" title="Edit">
                                        <i class="ph-pencil"></i>
                                    </a>
                                    <a href="#" class="text-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteBarangModal{{ $barang['id'] }}">
                                        <i class="ph-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Data barang belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('frontend.barang.create-modal')


    @foreach ($barangs as $barang)
        @include('frontend.barang.detail-modal', ['barang' => $barang])
        @include('frontend.barang.edit-modal', ['barang' => $barang])
        @include('frontend.barang.delete-modal', ['barang' => $barang])
    @endforeach
@endsection

