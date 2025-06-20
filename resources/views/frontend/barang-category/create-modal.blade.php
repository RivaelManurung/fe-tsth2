<div class="modal fade" id="createBarangCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Barang</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" id="createName" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="createCategory()">Tambah</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function createCategory() {
        const name = document.getElementById('createName').value;
        try {
            const response = await axios.post('/api/barang-categories', { name });
            alert(response.data.message);
            fetchCategories(); // Refresh table
            bootstrap.Modal.getInstance(document.getElementById('createBarangCategoryModal')).hide();
            document.getElementById('createName').value = ''; // Clear input
        } catch (error) {
            console.error('Error creating category:', error);
            alert(error.response?.data?.message || 'Gagal menambah kategori barang');
        }
    }
</script>