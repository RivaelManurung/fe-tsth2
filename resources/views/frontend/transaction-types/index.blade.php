@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        @include('components.flash-message')
        <div class="d-flex justify-content-between mb-3">
            <h4>Data Jenis Transaksi</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTransactionTypeModal">
                <i class="icon-database-add me-2"></i> Tambah Jenis Transaksi
            </button>
        </div>

        <table class="table table-bordered datatable-button-html5-basic">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactionTypes as $index => $transactionType)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $transactionType['name'] }}</td>
                        <td>{{ $transactionType['slug'] }}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#detailTransactionTypeModal{{ $transactionType['id'] }}"> <i
                                    class="ph-eye"></i></button>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editTransactionTypeModal{{ $transactionType['id'] }}"> <i
                                    class="ph-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteTransactionTypeModal{{ $transactionType['id'] }}"><i
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

    @include('frontend.transaction-types.create-modal')

    @foreach ($transactionTypes as $transactionType)
        @include('frontend.transaction-types.detail-modal', ['transactionType' => $transactionType])
        @include('frontend.transaction-types.edit-modal', ['transactionType' => $transactionType])
        @include('frontend.transaction-types.delete-modal', ['transactionType' => $transactionType])
    @endforeach
@endsection
