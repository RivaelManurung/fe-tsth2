@extends('layouts.main')

@section('content')

<!-- Tombol Tambah User -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal_create">
    Tambah User
</button>

<!-- Modal Tambah User -->
<div class="modal fade" id="modal_create" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="roles[]" class="form-control" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role['name'] }}">{{ $role['name'] }}</option>
                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>

                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
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
            @foreach ($users as $key => $user)
<<<<<<< HEAD
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['roles'][0] ?? '-' }}</td>
                    <td>
                        <!-- Tombol Aksi -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_show_{{ $user['id'] }}"><i class="ph-eye text-info"></i></a>
                        <form action="{{ route('users.destroy', $user['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 text-danger ms-2"><i class="ph-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Show -->
                <div class="modal fade" id="modal_show_{{ $user['id'] }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5>Detail User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nama:</strong> {{ $user['name'] }}</p>
                                <p><strong>Email:</strong> {{ $user['email'] }}</p>
                                <p><strong>Role:</strong> {{ $user['roles'][0] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div class="modal fade" id="modal_edit_{{ $user['id'] }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <form action="{{ route('users.update', $user['id']) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5>Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama</label>
                                        <input type="text" name="name" value="{{ $user['name'] }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ $user['email'] }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Password (opsional)</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Role</label>
                                        <select name="roles" class="form-control" required>
                                            @foreach ($roles as $role)
                                            <option value="{{ $role['id'] }}"
                                            {{ isset($user['roles'][0]) && $user['roles'][0] == $role['name'] ? 'selected' : '' }}>
                                            {{ $role['name'] }}
                                        </option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
=======
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $user['name'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['roles'][0] ?? '-' }}</td>
                <td>
                    <!-- Tombol Aksi -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal_show_{{ $user['id'] }}"><i
                            class="ph-eye text-info"></i></a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal_edit_{{ $user['id'] }}"><i
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

            <!-- Modal Show -->
            <div class="modal fade" id="modal_show_{{ $user['id'] }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5>Detail User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Nama:</strong> {{ $user['name'] }}</p>
                            <p><strong>Email:</strong> {{ $user['email'] }}</p>
                            <p><strong>Role:</strong> {{ $user['roles'][0] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="modal_edit_{{ $user['id'] }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <form action="{{ route('users.update', $user['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5>Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="name" value="{{ $user['name'] }}" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $user['email'] }}" class="form-control"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label>Password (opsional)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Role</label>
                                    <select name="roles" class="form-control" required>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role['id'] }}" {{ isset($user['roles'][0]) &&
                                            $user['roles'][0]==$role['name'] ? 'selected' : '' }}>
                                            {{ $role['name'] }}
                                        </option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
