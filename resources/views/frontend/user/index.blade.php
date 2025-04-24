@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        @include('components.flash-message')

        <div class="d-flex justify-content-between mb-3">
            <h4>Data Role</h4>
            <button type="button" class="btn btn-primary btn-labeled btn-labeled-start mb-2" data-bs-toggle="modal"
                data-bs-target="#createUserModal">
                <span class="btn-labeled-icon bg-black bg-opacity-20">
                    <i class="icon-database-add"></i>
                </span> Tambah User
            </button>
        </div>
        <!-- Tabel Users -->
        <div class="card">
            <div class="card-header">
                <h5>Data User</h5>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>{{ $user['roles'][0] ?? '-' }}</td>
                            <td>
                                <!-- Tombol Aksi -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#detailUser{{ $user['id'] }}"><i
                                        class="ph-eye text-info"></i></a>
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $user['id'] }}"><i
                                        class="ph-pen text-primary ms-2"></i></a>
                                <form action="{{ route('users.destroy', $user['id']) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger ms-2"><i
                                            class="ph-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('frontend.user.create-modal')
    @foreach ($users as $user)
        @include('frontend.user.detail-modal', ['user' => $user])
        @include('frontend.user.edit-modal', ['user' => $user])
        @include('frontend.user.delete-modal', ['user' => $user])
    @endforeach
@endsection
