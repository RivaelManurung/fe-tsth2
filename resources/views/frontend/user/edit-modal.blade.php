<div class="modal fade" id="editUserModal{{ $user['id'] }}" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form action="{{ route('users.update', $user['id']) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5>Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <x-form.group label="Nama" name="name" value="{{ $user['name'] }}" required />
                <x-form.group label="Email" name="email" value="{{ $user['email'] }}" type="email" required />
                <x-form.group label="Password (opsional)" name="password" type="password" />
                <x-form.group label="Konfirmasi Password" name="password_confirmation" type="password" />
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
