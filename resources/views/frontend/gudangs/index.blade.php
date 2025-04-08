@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <h4>Data Gudang</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGudangModal">
                <i class="icon-database-add me-2"></i> Tambah Gudang
            </button>
        </div>

        <table class="table table-bordered">
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
                @forelse ($gudangs as $index => $gudang)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $gudang['name'] }}</td>
                        <td>{{ $gudang['slug'] }}</td>
                        <td>{{ $gudang['description'] }}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#detailGudangModal{{ $gudang['id'] }}"> <i class="ph-eye"></i></button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editGudangModal{{ $gudang['id'] }}"> <i class="ph-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteGudangModal{{ $gudang['id'] }}"><i class="ph-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('frontend.gudangs.create-modal')

    @foreach ($gudangs as $gudang)
        @include('frontend.gudangs.detail-modal', ['gudang' => $gudang])
        @include('frontend.gudangs.edit-modal', ['gudang' => $gudang])
        @include('frontend.gudangs.delete-modal', ['gudang' => $gudang])
    @endforeach
@endsection
