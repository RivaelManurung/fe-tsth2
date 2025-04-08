<div class="modal fade" id="detailGudangModal{{ $gudang['id'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Gudang</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Nama Gudang</dt>
                    <dd class="col-sm-8">{{ $gudang['name'] }}</dd>

                    <dt class="col-sm-4">Slug</dt>
                    <dd class="col-sm-8">{{ $gudang['slug'] }}</dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8">{{ $gudang['description'] }}</dd>

                    {{-- <dt class="col-sm-4">Stok Tersedia</dt>
                    <dd class="col-sm-8">{{ $gudang['stok_tersedia'] }}</dd>

                    <dt class="col-sm-4">Stok Dipinjam</dt>
                    <dd class="col-sm-8">{{ $gudang['stok_dipinjam'] }}</dd>

                    <dt class="col-sm-4">Stok Maintenance</dt>
                    <dd class="col-sm-8">{{ $gudang['stok_maintenance'] }}</dd> --}}

                    <dt class="col-sm-4">Dibuat Pada</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($gudang['created_at'])->format('d-m-Y H:i') }}</dd>

                    <dt class="col-sm-4">Terakhir Diubah</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($gudang['updated_at'])->format('d-m-Y H:i') }}</dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
