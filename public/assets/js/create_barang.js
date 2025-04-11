
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formCreateBarang');
    const tombolSimpan = document.getElementById('tombolSimpan');
    const dropArea = document.getElementById('dropArea');
    const inputFile = document.getElementById('barang_gambar_input');
    const inputBase64 = document.getElementById('barang_gambar_base64');
    const gambarStatus = document.getElementById('gambarStatus');
    const gambarPreview = document.getElementById('gambarPreview');
    const gambarPreviewContainer = document.getElementById('gambarPreviewContainer');
    const progressBar = document.getElementById('submitProgress');
    const alertBox = document.getElementById('formAlert');
    const modalElement = document.getElementById('modalCreateBarang');
    const bsModal = new bootstrap.Modal(modalElement);

    // Progress & alert handling
    const showProgress = () => progressBar.style.display = 'block';
    const hideProgress = () => progressBar.style.display = 'none';
    const showAlert = (message, type = 'danger') => {
        alertBox.classList.remove('d-none', 'alert-success', 'alert-danger');
        alertBox.classList.add(`alert-${type}`);
        alertBox.innerText = message;
    };

    // Drag & Drop Image
    dropArea.addEventListener('click', () => inputFile.click());
    ['dragenter', 'dragover'].forEach(evt => {
        dropArea.addEventListener(evt, e => {
            e.preventDefault();
            dropArea.classList.add('bg-light');
        });
    });
    ['dragleave', 'drop'].forEach(evt => {
        dropArea.addEventListener(evt, e => {
            e.preventDefault();
            dropArea.classList.remove('bg-light');
        });
    });
    dropArea.addEventListener('drop', e => handleImage(e.dataTransfer.files[0]));
    inputFile.addEventListener('change', () => handleImage(inputFile.files[0]));

    function handleImage(file) {
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            gambarStatus.innerText = "Ukuran gambar maksimal 2MB.";
            gambarStatus.classList.replace('text-muted', 'text-danger');
            return;
        }

        gambarStatus.innerText = "Mengompres gambar...";
        gambarStatus.classList.replace('text-danger', 'text-muted');
        showProgress();

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {
                const canvas = document.createElement('canvas');
                const maxWidth = 600;
                const scale = maxWidth / img.width;
                canvas.width = maxWidth;
                canvas.height = img.height * scale;

                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                const compressedBase64 = canvas.toDataURL("image/jpeg", 0.7);

                inputBase64.value = compressedBase64;
                gambarPreview.src = compressedBase64;
                gambarPreviewContainer.classList.remove('d-none');
                gambarStatus.innerText = "Gambar siap disimpan.";
                hideProgress();
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

    // Submit
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!$(form).parsley().isValid()) return;

        showProgress();
        tombolSimpan.disabled = true;
        alertBox.classList.add('d-none');

        const formData = {
            barang_nama: form.barang_nama.value,
            barang_harga: form.barang_harga.value,
            barangcategory_id: form.barangcategory_id.value,
            jenisbarang_id: form.jenisbarang_id.value,
            satuan_id: form.satuan_id.value,
            stok_tersedia: form.stok_tersedia.value,
            barang_gambar: inputBase64.value
        };

        axios.post("{{ route('barangs.store') }}", formData, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            }
        })
            .then(response => {
                hideProgress();
                tombolSimpan.disabled = false;

                // Reset form
                form.reset();
                form.querySelectorAll('.is-valid').forEach(el => el.classList.remove(
                    'is-valid'));
                gambarPreviewContainer.classList.add('d-none');
                gambarStatus.innerText = "";
                inputBase64.value = "";

                bsModal.hide(); // Tutup modal

                // Refresh data
                window.location
                    .reload(); // Bisa kamu ganti jadi fetch ulang table jika pakai AJAX
            })
            .catch(error => {
                hideProgress();
                tombolSimpan.disabled = false;

                let message = "Terjadi kesalahan saat menyimpan.";
                if (error.response) {
                    message = error.response.data.message || message;
                    console.error("Status:", error.response.status);
                    console.error("Data:", error.response.data);
                } else if (error.request) {
                    message = "Tidak ada respon dari server.";
                    console.error("No response:", error.request);
                } else {
                    console.error("Error:", error.message);
                }

                showAlert(message);
            });
    });

    // Reset modal ketika dibuka ulang
    modalElement.addEventListener('hidden.bs.modal', function () {
        form.reset();
        inputBase64.value = "";
        gambarPreviewContainer.classList.add('d-none');
        gambarStatus.innerText = "";
        alertBox.classList.add('d-none');
        form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
            el.classList.remove('is-valid', 'is-invalid');
        });
    });
});

