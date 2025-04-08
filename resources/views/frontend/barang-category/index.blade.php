@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        @include('components.flash-message')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Data Kategori Barang</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="icon-database-add me-2"></i> Tambah Kategori Barang
            </button>
        </div>

        <table id="barangCategoriesTable" class="table table-bordered datatable-button-html5-basic">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangCategories as $index => $barangCategory)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $barangCategory['name'] }}</td>
                        <td>{{ $barangCategory['slug'] }}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#detailBarangCategoryModal{{ $barangCategory['id'] }}"> <i
                                    class="ph-eye"></i></button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editBarangCategoryModal{{ $barangCategory['id'] }}"> <i
                                    class="ph-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteBarangCategoryModal{{ $barangCategory['id'] }}"><i
                                    class="ph-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
            </tbody>
        </table>
    </div>

    @include('frontend.barang-category.create-modal')

    {{-- Modal Detail, Edit, Delete --}}
    @foreach ($barangCategories as $barangCategory)
        {{-- Detail --}}
        @include('frontend.barang-category.detail-modal', ['barangCategory' => $barangCategory])
        {{-- Edit --}}
        @include('frontend.barang-category.edit-modal', ['barangCategory' => $barangCategory])
        {{-- Delete --}}
        @include('frontend.barang-category.delete-modal', ['barangCategory' => $barangCategory])
    @endforeach
@endsection
