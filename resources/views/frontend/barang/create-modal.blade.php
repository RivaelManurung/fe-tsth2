<!-- Modal Create Barang -->
<div class="modal fade" id="modalCreateBarang" tabindex="-1" aria-labelledby="modalCreateBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('barangs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateBarangLabel">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-6">
                        <label for="barang_nama" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="barang_nama" required>
                    </div>

                    <div class="col-md-6">
                        <label for="barang_harga" class="form-label">Harga Barang</label>
                        <input type="number" class="form-control" name="barang_harga" required>
                    </div>

                    <div class="col-md-6">
                        <label for="barangcategory_id" class="form-label">Kategori</label>
                        <select name="barangcategory_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori_barangs as $category)
                                <option value="{{ $category['id'] }}"
                                    {{ $barang['barangcategory_id'] == $category['id'] ? 'selected' : '' }}>
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="jenisbarang_id" class="form-label">Jenis Barang</label>
                        <select name="jenisbarang_id" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach ($jenis_barangs as $jenis)
                                <option value="{{ $jenis['id'] }}"
                                    {{ isset($barang['jenisBarang']) && ((is_array($barang['jenisBarang']) && $barang['jenisBarang']['id'] == $jenis['id']) || $barang['jenisBarang'] == $jenis['name']) ? 'selected' : '' }}>
                                    {{ $jenis['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="satuan_id" class="form-label">Satuan</label>
                        <select name="satuan_id" class="form-select" required>
                            <option value="">-- Pilih Satuan --</option>
                            @foreach ($satuans as $satuan)
                                <option value="{{ $satuan['id'] }}"
                                    {{ isset($barang['satuan']) && ((is_array($barang['satuan']) && $barang['satuan']['id'] == $satuan['id']) || $barang['satuan'] == $satuan['name']) ? 'selected' : '' }}>
                                    {{ $satuan['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="gudang_id" class="form-label">Gudang</label>
                        <select name="gudang_id" class="form-select" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach ($barang['gudangs'] as $gudang)
                                <option value="{{ $gudang['id'] }}">{{ $gudang['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="stok_tersedia" class="form-label">Stok Tersedia</label>
                        <input type="number" name="stok_tersedia" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="barang_gambar" class="form-label">Gambar Barang</label>
                        <input type="file" name="barang_gambar" class="form-control" accept="image/*">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
