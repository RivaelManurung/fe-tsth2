<!-- Modal Edit Barang -->
<div class="modal fade" id="editBarangModal{{ $barang['id'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formEditBarang{{ $barang['id'] }}" method="POST" data-id="{{ $barang['id'] }}" class="form-edit-barang"
            data-parsley-validate>
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">
                    <input type="hidden" name="id" value="{{ $barang['id'] }}">

                    <div class="col-md-6">
                        <label>Nama Barang</label>
                        <input type="text" name="barang_nama" class="form-control" required
                            value="{{ $barang['barang_nama'] }}">
                    </div>

                    <div class="col-md-6">
                        <label>Harga Barang</label>
                        <input type="number" name="barang_harga" class="form-control" required
                            value="{{ $barang['barang_harga'] }}">
                    </div>

                    <div class="col-md-6">
                        <label>Kategori</label>
                        <select name="barangcategory_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori_barangs as $category)
                                <option value="{{ $category['id'] }}"
                                    {{ $category['id'] == $barang['barangcategory_id'] ? 'selected' : '' }}>
                                    {{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Jenis Barang</label>
                        <select name="jenisbarang_id" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach ($jenis_barangs as $jenis)
                                <option value="{{ $jenis['id'] }}"
                                    {{ $jenis['id'] == $barang['jenisbarang_id'] ? 'selected' : '' }}>
                                    {{ $jenis['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="col-md-6">
                        <label>Gambar Barang</label>
                        <div class="drop-area border rounded p-3 text-center" style="cursor:pointer;"
                            data-id="{{ $barang['id'] }}">
                            <p>Seret gambar ke sini atau klik untuk unggah</p>
                            <input type="file" class="file-input d-none" accept="image/*">
                        </div>
                        <small class="gambar-status text-muted d-block mt-1"></small>
                        <div class="preview-container mt-2 {{ $barang['barang_gambar'] ? '' : 'd-none' }}">
                            <img src="{{ asset($barang['barang_gambar']) }}" class="img-thumbnail preview-img"
                                style="max-height:200px;">
                        </div>
                        <input type="hidden" name="barang_gambar" class="gambar-base64"
                            value="{{ $barang['barang_gambar'] }}">
                    </div>

                    <div class="col-md-6">
                        <label>Satuan</label>
                        <select name="satuan_id" class="form-select" required>
                            <option value="">-- Pilih Satuan --</option>
                            @foreach ($satuans as $satuan)
                                <option value="{{ $satuan['id'] }}"
                                    {{ $satuan['id'] == $barang['satuan_id'] ? 'selected' : '' }}>
                                    {{ $satuan['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="progress submit-progress d-none" style="height: 20px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">
                                Menyimpan...</div>
                        </div>
                        <div class="alert alert-danger mt-3 d-none form-alert" role="alert"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary tombol-update">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-edit-barang').forEach(form => {
            const id = form.dataset.id;
            const dropArea = form.querySelector('.drop-area');
            const inputFile = dropArea.querySelector('.file-input');
            const gambarStatus = form.querySelector('.gambar-status');
            const previewImg = form.querySelector('.preview-img');
            const previewContainer = form.querySelector('.preview-container');
            const inputBase64 = form.querySelector('.gambar-base64');
            const progressBar = form.querySelector('.submit-progress');
            const alertBox = form.querySelector('.form-alert');
            const tombolUpdate = form.querySelector('.tombol-update');

            // Drag & Drop handler
            dropArea.addEventListener('click', () => inputFile.click());
            ['dragenter', 'dragover'].forEach(evt => dropArea.addEventListener(evt, e => {
                e.preventDefault();
                dropArea.classList.add('bg-light');
            }));
            ['dragleave', 'drop'].forEach(evt => dropArea.addEventListener(evt, e => {
                e.preventDefault();
                dropArea.classList.remove('bg-light');
            }));
            dropArea.addEventListener('drop', e => handleImage(e.dataTransfer.files[0]));
            inputFile.addEventListener('change', () => handleImage(inputFile.files[0]));

            function handleImage(file) {
                if (!file || file.type.indexOf('image') === -1) return;

                if (file.size > 2 * 1024 * 1024) {
                    gambarStatus.innerText = "Ukuran gambar maksimal 2MB.";
                    gambarStatus.classList.replace('text-muted', 'text-danger');
                    return;
                }

                gambarStatus.innerText = "Mengompres gambar...";
                gambarStatus.classList.replace('text-danger', 'text-muted');

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        const maxWidth = 600;
                        const scale = maxWidth / img.width;
                        canvas.width = maxWidth;
                        canvas.height = img.height * scale;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        const compressed = canvas.toDataURL("image/jpeg", 0.7);
                        inputBase64.value = compressed;
                        previewImg.src = compressed;
                        previewContainer.classList.remove('d-none');
                        gambarStatus.innerText = "Gambar siap disimpan.";
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }

            // Live validation
            form.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', () => {
                    input.classList.toggle('is-valid', input.checkValidity());
                    input.classList.toggle('is-invalid', !input.checkValidity());
                });
            });

            // Submit handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!$(form).parsley().isValid()) return;

                progressBar.classList.remove('d-none');
                tombolUpdate.disabled = true;
                alertBox.classList.add('d-none');

                const formData = {
                    barang_nama: form.barang_nama.value,
                    barang_harga: form.barang_harga.value,
                    barangcategory_id: form.barangcategory_id.value,
                    jenisbarang_id: form.jenisbarang_id.value,
                    satuan_id: form.satuan_id.value,
                    barang_gambar: inputBase64.value,
                };

                axios.put(`/barangs/${id}`, formData, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content'),
                        }
                    })
                    .then(res => {
                        progressBar.classList.add('d-none');
                        tombolUpdate.disabled = false;

                        // Tutup modal manual
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            `editBarangModal${id}`));
                        modal.hide();

                        // Flash message (manual inject ke alert container di halaman)
                        const flashContainer = document.getElementById('flash-container');
                        if (flashContainer) {
                            flashContainer.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                Barang berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                        }

                        // Optional reload (delay dikit biar flash keliatan)
                        setTimeout(() => window.location.reload(), 1500);
                    })

                    .catch(err => {
                        tombolUpdate.disabled = false;
                        progressBar.classList.add('d-none');
                        const msg = err.response?.data?.message || "Gagal menyimpan data.";
                        alertBox.innerText = msg;
                        alertBox.classList.remove('d-none');
                    });
            });
        });
    });
</script>
