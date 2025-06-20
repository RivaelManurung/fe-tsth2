@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Daftar Transaksi</h4>
    <div>
        @can('create_transaction')
        <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-labeled btn-labeled-start mb-2">
            <span class="btn-labeled-icon bg-black bg-opacity-20">
                <i class="icon-plus-circle2"></i>
            </span> Tambah Transaksi
        </a>
        @endcan
    </div>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Table Transaksi</h5>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>User</th>
                    <th>Jumlah Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $key => $trx)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $trx['transaction_code'] ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx['transaction_date'] ?? now())->format('d-m-Y') }}</td>
                    <td>{{ $trx['transaction_type']['name'] ?? '-' }}</td>
                    <td>{{ $trx['user']['name'] ?? '-' }}</td>
                    <td>{{ count($trx['items'] ?? []) }}</td>
                    <td>
                        <div class="d-flex">
                            @if (isset($trx['id']))
                            @can('view_transaction')
                            <a href="#" class="text-info me-2" data-bs-toggle="modal"
                                data-bs-target="#detailTransaction{{ $trx['id'] }}" title="Detail">
                                <i class="ph-eye"></i>
                            </a>
                            @endcan
                            {{-- @can('edit_transaction') --}}
                            <a href="#" class="text-warning me-2" data-bs-toggle="modal"
                                data-bs-target="#editTransactionModal{{ $trx['id'] }}" title="Edit Transaksi">
                                <i class="ph-pencil"></i>
                            </a>
                            {{-- @endcan --}}
                            @else
                            <span class="text-muted">Aksi tidak tersedia</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Data transaksi belum tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@foreach ($transactions as $trx)
@if (isset($trx['id']))
@include('frontend.transaksi.detil', ['transaction_id' => $trx['id'], 'transaction' => $trx])

<!-- Edit Transaction Modal -->
<div class="modal fade" id="editTransactionModal{{ $trx['id'] }}" tabindex="-1"
    aria-labelledby="editTransactionLabel{{ $trx['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editTransactionLabel{{ $trx['id'] }}">
                    <i class="fas fa-edit me-2"></i> Edit Transaksi - {{ $trx['transaction_code'] ?? 'Unknown' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('transactions.update', $trx['id']) }}" method="POST"
                    id="editTransactionForm{{ $trx['id'] }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong class="text-muted">Kode Transaksi:</strong>
                        </div>
                        <div class="col-md-8">
                            <span class="text-dark">{{ $trx['transaction_code'] ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong class="text-muted">Tanggal:</strong>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="transaction_date" class="form-control"
                                value="{{ \Carbon\Carbon::parse($trx['transaction_date'] ?? now())->format('Y-m-d') }}"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong class="text-muted">Jenis Transaksi:</strong>
                        </div>
                        <div class="col-md-8">
                            <select name="transaction_type_id" id="transaction_type_id_{{ $trx['id'] }}"
                                class="form-control" required>
                                @foreach ($transactionTypes as $type)
                                <option value="{{ $type['id'] }}" {{ ($trx['transaction_type']['id'] ?? 0)==$type['id']
                                    ? 'selected' : '' }}>
                                    {{ $type['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong class="text-muted">Operator:</strong>
                        </div>
                        <div class="col-md-8">
                            <span class="text-dark">{{ $trx['user']['name'] ?? '-' }}</span>
                            <input type="hidden" name="user_id" value="{{ $trx['user']['id'] ?? auth()->id() }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong class="text-muted">Deskripsi:</strong>
                        </div>
                        <div class="col-md-8">
                            <textarea name="description" id="description_{{ $trx['id'] }}"
                                class="form-control">{{ $trx['description'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Tabel Daftar Barang -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong class="text-muted">Daftar Barang:</strong>
                            <table class="table table-striped table-bordered mt-2">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $daftarBarang = collect($trx['items'] ?? [])->mapWithKeys(function ($item, $index) {
                                    $kode = $item['barang']['kode'] ?? ($item['barang_kode'] ?? 'unknown_' . $index);
                                    return [
                                    $kode => [
                                    'nama' => $item['barang']['nama'] ?? ($item['barang_nama'] ?? 'Unknown'),
                                    'kode' => $kode,
                                    'jumlah' => $item['quantity'] ?? 1,
                                    'kategoribarang' => $item['barang']['kategori'] ?? ($item['kategoribarang'] ?? ''),
                                    'stok_tersedia' => $item['barang']['stok_tersedia'] ?? ($item['stok_tersedia'] ??
                                    0),
                                    'gambar' => $item['barang']['gambar'] ?? ($item['gambar'] ?? ''),
                                    'satuan_id' => $item['satuan_id'] ?? ($item['barang']['satuan']['id'] ?? null),
                                    'satuan' => $item['barang']['satuan']['nama'] ?? ($item['satuan'] ?? 'Unknown'),
                                    'description' => $item['description'] ?? '',
                                    ]
                                    ];
                                    })->toArray();
                                    @endphp
                                    @forelse ($daftarBarang as $kode => $barang)
                                    <tr>
                                        <td>{{ $barang['nama'] }}</td>
                                        <td>
                                            <input type="number" name="items[{{$loop->index}}][jumlah]"
                                                value="{{ $barang['jumlah'] }}" class="form-control" min="1" required>
                                        </td>
                                        <td>
                                            <select name="items[{{$loop->index}}][satuan_id]" class="form-control"
                                                required>
                                                <option value="" {{ is_null($barang['satuan_id']) ? 'selected' : '' }}>
                                                    Pilih Satuan</option>
                                                @foreach ($satuanList as $satuan)
                                                <option value="{{ $satuan['id'] }}" {{
                                                    $barang['satuan_id']==$satuan['id'] ? 'selected' : '' }}>
                                                    {{ $satuan['name'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="items[{{$loop->index}}][description]"
                                                value="{{ $barang['description'] }}" class="form-control">
                                        </td>
                                    </tr>
                                    <input type="hidden" name="items[{{$loop->index}}][kode]"
                                        value="{{ $barang['kode'] }}">
                                    <input type="hidden" name="items[{{$loop->index}}][nama]"
                                        value="{{ $barang['nama'] }}">
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada barang ditambahkan.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-2"></i>Simpan
                            Transaksi</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection

@section('scripts')
<script>
    // Debug detail modal clicks
    document.querySelectorAll('[data-bs-target^="#detailTransactionModal"]').forEach(link => {
        link.addEventListener('click', function (e) {
            console.log('Detail modal triggered for ID:', this.getAttribute('data-bs-target'));
        });
    });

    // Debug edit form submission
    document.querySelectorAll('[id^="editTransactionForm"]').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default submission for debugging
            console.log('Submitting form:', form.id);
            console.log('Form data:', Object.fromEntries(new FormData(form)));
            form.submit(); // Proceed with submission
        });
    });
</script>
@endsection