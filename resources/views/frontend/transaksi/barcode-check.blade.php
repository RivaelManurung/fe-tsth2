@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Input Barang</h2>
        <p class="text-muted">Pilih metode input dan masukkan data barang dengan mudah</p>
    </div>

    <!-- Toggle Button -->
    <div class="d-flex justify-content-center mb-4">
        <div class="btn-group shadow" role="group" aria-label="Metode Input">
            <button type="button" class="btn btn-outline-primary active px-4 py-2 fs-5" id="btn-scan">
                <i class="bi bi-upc-scan me-2"></i>Scan Barcode
            </button>
            <button type="button" class="btn btn-outline-secondary px-4 py-2 fs-5" id="btn-manual">
                <i class="bi bi-keyboard me-2"></i>Input Manual
            </button>
        </div>
    </div>

    <!-- Scanner -->
    <div id="scanner-section" class="d-flex justify-content-center mb-4">
        <div id="reader" class="border border-3 rounded shadow-lg" style="width:100%; max-width:400px; aspect-ratio:1/1;"></div>
    </div>

    <!-- Manual Input -->
    <div id="manual-section" class="d-none d-flex justify-content-center mb-4">
        <div class="w-75">
            <label for="manual-input" class="form-label text-muted">Masukkan Kode Barang</label>
            <input type="text" id="manual-input" class="form-control shadow-sm" placeholder="Contoh: BRG123">
            <p id="manual-error" class="text-danger mt-2 d-none">Kode barang tidak valid.</p>
            <p id="manual-success" class="text-success mt-2 d-none">Kode barang ditemukan!</p>
        </div>
    </div>

    <!-- Scan result -->
    <p id="scan-result" class="text-success mt-2 fw-bold text-center"></p>

    <!-- Transaction Type -->
    <div class="mb-4">
        <label for="transaction-type" class="form-label">Tipe Transaksi:</label>
        <select id="transaction-type" class="form-select">
            @foreach ($transactionTypes as $type)
                <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
            @endforeach
        </select>
    </div>

    <hr class="my-5">
    <!-- Reset Button -->
    <div class="d-flex justify-content-start mb-5">
        <form method="GET" action="{{ route('barcode.reset') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-lg px-5 py-2 shadow-sm">
                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Daftar
            </button>
        </form>
    </div>

    <!-- Tabel Barang -->
    <div id="tabel-barang">
        @if(count($daftarBarang) > 0)
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered shadow-sm">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Gambar</th>
                            <th>Stok Tersedia</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftarBarang as $item)
                        <tr id="item-{{ $item['kode'] }}">
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['kode'] }}</td>
                            <td>
                                <a href="{{ asset($item['gambar']) }}" data-lightbox="gambar-{{ $item['kode'] }}">
                                    <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}" style="width: 50px; height: 50px; object-fit: cover;">
                                </a>
                            </td>
                            <td>{{ $item['stok_tersedia'] }}</td>
                            <td class="text-center">
                                <button class="btn btn-outline-danger btn-sm" onclick="updateQuantity('{{ $item['kode'] }}', -1)">-</button>
                                <span id="jumlah-{{ $item['kode'] }}" class="mx-2">{{ $item['jumlah'] }}</span>
                                <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity('{{ $item['kode'] }}', 1)">+</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger" onclick="removeItem('{{ $item['kode'] }}')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="d-flex justify-content-end mt-4">
            <button class="btn btn-success btn-lg shadow" id="btn-kirim">
                <i class="bi bi-send-fill me-2"></i>Kirim
            </button>
        </div>

        @else
        <p class="text-muted mt-3 text-center">Belum ada barang yang dimasukkan.</p>
        @endif
    </div>
</div>
@endsection

@push('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const scannerSound = new Audio("{{ asset('scanner.mp3') }}");

    document.addEventListener('DOMContentLoaded', function () {
        const btnScan = document.getElementById('btn-scan');
        const btnManual = document.getElementById('btn-manual');
        const scannerSection = document.getElementById('scanner-section');
        const manualSection = document.getElementById('manual-section');
        const manualError = document.getElementById('manual-error');
        const manualSuccess = document.getElementById('manual-success');

        btnScan.addEventListener('click', () => {
            btnScan.classList.add('active');
            btnManual.classList.remove('active');
            scannerSection.classList.remove('d-none');
            manualSection.classList.add('d-none');
        });

        btnManual.addEventListener('click', () => {
            btnManual.classList.add('active');
            btnScan.classList.remove('active');
            manualSection.classList.remove('d-none');
            scannerSection.classList.add('d-none');
            manualError.classList.add('d-none');
            manualSuccess.classList.add('d-none');
        });

        const scanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        scanner.render(onScanSuccess);

        document.getElementById('manual-input').addEventListener('input', handleManualInput);
    });

    function onScanSuccess(decodedText) {
        document.getElementById('scan-result').innerText = 'Scanned: ' + decodedText;
        sendCode(decodedText);
    }

    function handleManualInput(event) {
        const kode = event.target.value;
        if (kode.length > 0) {
            sendCode(kode);
        } else {
            document.getElementById('manual-error').classList.add('d-none');
            document.getElementById('manual-success').classList.add('d-none');
        }
    }

    function sendCode(kode) {
        fetch("{{ route('barcode.check') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            body: JSON.stringify({ kode })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('tabel-barang').innerHTML = data.html;
                document.getElementById('scan-result').innerText = '';
                document.getElementById('manual-error').classList.add('d-none');
                document.getElementById('manual-success').classList.remove('d-none');
                scannerSound.play();
            } else {
                document.getElementById('scan-result').innerText = 'Error: ' + data.message;
                document.getElementById('manual-error').classList.remove('d-none');
                document.getElementById('manual-success').classList.add('d-none');
            }
        })
        .catch(() => {
            document.getElementById('manual-error').classList.remove('d-none');
            document.getElementById('manual-success').classList.add('d-none');
        });
    }

    function updateQuantity(kode, increment) {
        const jumlahElement = document.getElementById('jumlah-' + kode);
        let jumlah = parseInt(jumlahElement.innerText);
        if (jumlah + increment >= 0) {
            jumlah += increment;
            jumlahElement.innerText = jumlah;

            fetch("{{ route('barcode.check') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({ kode: kode, jumlah: jumlah })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                }
            })
            .catch(() => {
                alert('Terjadi kesalahan saat memperbarui jumlah.');
            });
        }
    }

    function removeItem(kode) {
        if (confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
            fetch("{{ route('barcode.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify({ kode: kode })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const itemRow = document.getElementById('item-' + kode);
                    if (itemRow) itemRow.remove();
                    document.getElementById('scan-result').innerText = 'Barang berhasil dihapus!';
                } else {
                    alert('Gagal menghapus barang: ' + data.message);
                }
            })
            .catch(() => {
                alert('Terjadi kesalahan saat menghapus barang.');
            });
        }
    }
</script>
@endpush
