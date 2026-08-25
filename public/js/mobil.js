/**
 * Fungsi untuk mengambil data mobil dan menampilkannya di Modal Edit
 * @param {number} id - ID Mobil dari database
 */
function editMobil(id) {
    // 1. Lakukan request ke server untuk ambil data JSON
    fetch(`/mobil/${id}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data dari server');
            }
            return response.json();
        })
        .then(data => {
            // 2. Isi value masing-masing input di modal edit
            document.getElementById('edit_seri').value = data.seri;
            document.getElementById('edit_nama').value = data.nama_mobil;
            document.getElementById('edit_merek').value = data.merek;
            document.getElementById('edit_tahun').value = data.tahun || '';
            document.getElementById('edit_mesin').value = data.mesin || '';
            document.getElementById('edit_cc').value = data.cc || '';
            document.getElementById('edit_transmisi').value = data.transmisi || '';
            document.getElementById('edit_bahan_bakar').value = data.bahan_bakar || '';
            document.getElementById('edit_warna').value = data.warna || '';
            document.getElementById('edit_penggerak').value = data.penggerak || '';
            document.getElementById('edit_harga').value = new Intl.NumberFormat('id-ID').format(data.harga);
            document.getElementById('edit_harga_value').value = data.harga;
            document.getElementById('edit_stok').value = data.stok;
            
            // 3. Update atribut 'action' pada form agar mengarah ke route update yang benar
            const editForm = document.getElementById('formEditMobil');
            editForm.action = `/mobil/${id}`;
            
            // 4. Munculkan modal edit menggunakan Bootstrap 5 API
            const modalElement = document.getElementById('modalEditMobil');
            const editModal = new bootstrap.Modal(modalElement);
            editModal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data mobil.');
        });
}