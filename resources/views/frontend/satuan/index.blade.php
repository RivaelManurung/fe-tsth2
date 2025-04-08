@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        @include('components.flash-message')
        <div class="d-flex justify-content-between mb-3">
            <h4>Data Satuan Barang</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSatuanModal">
                <i class="icon-database-add me-2"></i> Tambah Satuan Barang
            </button>
        </div>

        <table class="table table-bordered datatable-button-html5-basic">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($satuans as $index => $satuan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $satuan['name'] }}</td>
                        <td>{{ $satuan['slug'] }}</td>
                        <td>{{ $satuan['description'] ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#detailSatuanModal{{ $satuan['id'] }}"> <i class="ph-eye"></i></button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editSatuanModal{{ $satuan['id'] }}"> <i class="ph-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteSatuanModal{{ $satuan['id'] }}"><i class="ph-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('frontend.satuan.create-modal')

    @foreach ($satuans as $satuan)
        @include('frontend.satuan.detail-modal', ['satuan' => $satuan])
        @include('frontend.satuan.edit-modal', ['satuan' => $satuan])
        @include('frontend.satuan.delete-modal', ['satuan' => $satuan])
    @endforeach
@endsection
