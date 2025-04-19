<div id="tabel-barang">
@if(count($daftarBarang) > 0)
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

@else
<p class="text-muted mt-3">Belum ada barang yang discan.</p>
@endif

</div>
