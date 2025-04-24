<div class="modal fade" id="detailUser{{ $user['id'] }}" tabindex="-1">
    <div class="modal-dialog modal-md">
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
