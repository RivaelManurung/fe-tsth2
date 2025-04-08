@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        @include('components.flash-message')
        <div class="d-flex justify-content-between mb-3">
            <h4>Data Jenis Barang</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJenisBarangModal">
                <i class="icon-database-add me-2"></i> Tambah Jenis Barang
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
                @forelse ($jenisBarangs as $index => $jenisBarang)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $jenisBarang['name'] }}</td>
                        <td>{{ $jenisBarang['slug'] }}</td>
                        <td>{{ $jenisBarang['description'] ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#detailJenisBarangModal{{ $jenisBarang['id'] }}"> <i
                                    class="ph-eye"></i></button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editJenisBarangModal{{ $jenisBarang['id'] }}"> <i
                                    class="ph-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteJenisBarangModal{{ $jenisBarang['id'] }}"><i
                                    class="ph-trash"></i></button>
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

    @include('frontend.jenis-barangs.create-modal')

    @foreach ($jenisBarangs as $jenisBarang)
        @include('frontend.jenis-barangs.detail-modal', ['jenisBarang' => $jenisBarang])
        @include('frontend.jenis-barangs.edit-modal', ['jenisBarang' => $jenisBarang])
        @include('frontend.jenis-barangs.delete-modal', ['jenisBarang' => $jenisBarang])
    @endforeach
@endsection
