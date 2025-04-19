@extends('layouts.main')

@section('content')
@include('components.flash-message')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center fs-5">
                    Scan Barang Transaksi
                </div>
                <div class="card-body p-3">

                    <div id="reader-container" class="w-100 d-flex justify-content-center mb-4">
                        <div id="reader" class="border border-3 rounded" style="width: 100%; max-width: 100%; aspect-ratio: 1 / 1;"></div>
                    </div>

                    <div class="mb-4">
                        <label for="product-code" class="form-label">Kode Barang:</label>
                        <input type="text" id="product-code" class="form-control" readonly />
                    </div>

                    <div class="mb-4">
                        <label for="transaction-type" class="form-label">Tipe Transaksi:</label>
                        <select id="transaction-type" class="form-select">
                            @foreach ($transactionTypes as $type)
                                <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <div class="mt-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center" id="items-table">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Hasil scan ditambahkan ke sini -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-end mt-3">
                <button id="submit-btn" class="btn btn-success px-4">
                    Kirim Transaksi
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const html5QrCode = new Html5Qrcode("reader");
    const tableBody = document.querySelector('#items-table tbody');
    const scanSound = new Audio("/scanner.mp3");
    let isScanningAllowed = true;

    const config = {
        fps: 10,
        qrbox: (w, h) => {
            const edge = Math.min(w, h);
            return { width: edge * 0.8, height: edge * 0.8 };
        },
        aspectRatio: 1
    };

    Html5Qrcode.getCameras().then((cameras) => {
        if (!cameras.length) {
            alert("Kamera tidak ditemukan.");
            return;
        }

        const backCam = cameras.find(cam => cam.label.toLowerCase().includes('back')) || cameras[0];

        html5QrCode.start(
            { deviceId: { exact: backCam.id } },
            config,
            (decodedText) => {
                if (!isScanningAllowed) return;

                isScanningAllowed = false;
                scanSound.play();
                document.getElementById('reader').style.borderColor = 'green';
                document.getElementById('product-code').value = decodedText;

                setTimeout(() => {
                    document.getElementById('reader').style.borderColor = '#ccc';
                    isScanningAllowed = true;
                }, 1500);

                fetch(`/barcode/check?kode=${decodedText}`)
                    .then((res) => res.json())
                    .then((data) => {
                        if (!data || !data.barang_nama || !data.barang_kode) {
                            alert("Barang tidak ditemukan.");
                            return;
                        }

                        let existingRow = Array.from(tableBody.querySelectorAll('tr')).find(row =>
                            row.dataset.kode === data.barang_kode
                        );

                        if (existingRow) {
                            const qtyElem = existingRow.querySelector('.item-qty');
                            qtyElem.textContent = parseInt(qtyElem.textContent) + 1;
                        } else {
                            const rowCount = tableBody.rows.length + 1;
                            const row = document.createElement('tr');
                            row.dataset.kode = data.barang_kode;
                            row.innerHTML = `
                                <td>${rowCount}</td>
                                <td class="item-name text-success fw-semibold">${data.barang_nama}</td>
                                <td class="item-qty">1</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); updateRowNumbers();">Hapus</button>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        }
                    })
                    .catch((err) => {
                        console.error("Fetch error:", err);
                        alert("Terjadi kesalahan saat mengambil data barang.");
                    });
            },
            (err) => {
                // Silent scan errors
            }
        );
    }).catch((err) => {
        console.error("Camera init error:", err);
    });

    window.updateRowNumbers = () => {
        document.querySelectorAll('#items-table tbody tr').forEach((row, i) => {
            row.children[0].textContent = i + 1;
        });
    };

    document.getElementById('submit-btn').addEventListener('click', () => {
        const rows = document.querySelectorAll('#items-table tbody tr');
        const transactionType = document.getElementById('transaction-type').value;
        const data = [];

        rows.forEach((row) => {
            const kode = row.dataset.kode;
            const nama = row.querySelector('.item-name')?.textContent;
            const qty = row.querySelector('.item-qty')?.textContent;
            if (kode && nama && qty) {
                data.push({ kode, nama, qty });
            }
        });

        if (data.length === 0) {
            alert("Belum ada data barang yang discan.");
            return;
        }

        fetch('/transaksi/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                tipe: transactionType,
                barang: data
            })
        })
        .then((res) => res.json())
        .then((res) => {
            alert("Transaksi berhasil disimpan!");
            location.reload();
        })
        .catch((err) => {
            console.error("Submit error:", err);
            alert("Gagal menyimpan transaksi.");
        });
    });
});
</script>
@endpush
