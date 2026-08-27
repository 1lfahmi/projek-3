function normalizePriceValue(value) {
    const digits = String(value ?? '').replace(/[^\d]/g, '');
    return digits;
}

function formatPriceDisplay(value) {
    const digits = normalizePriceValue(value);
    if (!digits) {
        return '';
    }

    return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(Number(digits));
}

function formatPriceLabel(value) {
    const digits = normalizePriceValue(value);
    if (!digits) {
        return 'Rp 0';
    }

    return `Rp ${formatPriceDisplay(digits)}`;
}

/**
 * Fungsi untuk mengambil data mobil dan menampilkannya di Modal Edit
 * @param {number} id - ID Mobil dari database
 */
function editMobil(id) {
    fetch(`/mobil/${id}/edit`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data dari server');
            }
            return response.json();
        })
        .then(data => {
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
            document.getElementById('edit_harga').value = formatPriceDisplay(data.harga || 0);
            document.getElementById('edit_harga_value').value = normalizePriceValue(data.harga || 0);
            document.getElementById('edit_stok').value = data.stok;
            document.getElementById('editPreviewNama').textContent = data.nama_mobil || 'Nama kendaraan';
            document.getElementById('editPreviewMerek').textContent = data.merek || 'Merek';
            document.getElementById('editPreviewTahun').textContent = data.tahun || 'Tahun';
            document.getElementById('editPreviewHarga').textContent = formatPriceLabel(data.harga || 0);

            const editForm = document.getElementById('formEditMobil');
            editForm.action = `/mobil/${id}`;

            const preview = document.getElementById('editFotoPreview');
            const placeholder = document.getElementById('editFotoPlaceholder');
            window.editExistingPhotos = Array.isArray(data.foto_url) ? data.foto_url : (data.foto_url ? [data.foto_url] : []);
            window.editNewPhotoUrls = [];
            window.editPhotoIndex = 0;
            updateEditGallery();

            const modalElement = document.getElementById('modalEditMobil');
            const editModal = new bootstrap.Modal(modalElement);
            editModal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data mobil.');
        });
}

document.addEventListener('DOMContentLoaded', function () {
    const editFotoInput = document.getElementById('editFotoInput');
    const editFotoPreview = document.getElementById('editFotoPreview');
    const editFotoPlaceholder = document.getElementById('editFotoPlaceholder');
    const editGallery = document.getElementById('editGallery');
    const editFotoDots = document.getElementById('editFotoDots');
    const editFotoPrev = document.getElementById('editFotoPrev');
    const editFotoNext = document.getElementById('editFotoNext');
    window.editExistingPhotos = [];
    window.editNewPhotoUrls = [];
    window.editPhotoIndex = 0;

    window.updateEditGallery = function () {
        const photos = window.editExistingPhotos.concat(window.editNewPhotoUrls);
        const hasPhotos = photos.length > 0;
        editFotoPreview.src = hasPhotos ? photos[window.editPhotoIndex] : '';
        editFotoPreview.style.display = hasPhotos ? 'block' : 'none';
        editFotoPlaceholder.style.display = hasPhotos ? 'none' : 'flex';
        editGallery.classList.toggle('has-gallery', photos.length > 1);
        editFotoDots.innerHTML = photos.map((photo, index) => `<button type="button" class="gallery-dot ${index === window.editPhotoIndex ? 'active' : ''}" aria-label="Foto ${index + 1}"></button>`).join('');
        editFotoDots.querySelectorAll('.gallery-dot').forEach((dot, index) => dot.addEventListener('click', () => {
            window.editPhotoIndex = index;
            updateEditGallery();
        }));
    };
    let editFotoFiles = [];
    let editFotoUrls = [];

    if (editFotoInput) {
        editFotoInput.addEventListener('change', function () {
            const files = Array.from(this.files || []);
            if (files.length === 0) {
                return;
            }

            if (files.length > 5) {
                alert('Maksimal 5 gambar yang dapat dipilih untuk mengganti foto.');
                editFotoInput.value = '';
                editFotoFiles = [];
                editFotoUrls.forEach(url => URL.revokeObjectURL(url));
                editFotoUrls = [];
                window.editNewPhotoUrls = [];
                updateEditGallery();
                return;
            }

            editFotoFiles = files;
            editFotoUrls.forEach(url => URL.revokeObjectURL(url));
            editFotoUrls = editFotoFiles.map(file => URL.createObjectURL(file));

            const transfer = new DataTransfer();
            editFotoFiles.forEach(file => transfer.items.add(file));
            editFotoInput.files = transfer.files;

            window.editNewPhotoUrls = editFotoUrls;
            window.editPhotoIndex = 0;
            updateEditGallery();
        });
    }

    editFotoPrev.addEventListener('click', () => {
        const total = window.editExistingPhotos.length + window.editNewPhotoUrls.length;
        if (total > 1) {
            window.editPhotoIndex = (window.editPhotoIndex - 1 + total) % total;
            updateEditGallery();
        }
    });
    editFotoNext.addEventListener('click', () => {
        const total = window.editExistingPhotos.length + window.editNewPhotoUrls.length;
        if (total > 1) {
            window.editPhotoIndex = (window.editPhotoIndex + 1) % total;
            updateEditGallery();
        }
    });

    document.getElementById('modalEditMobil').addEventListener('hidden.bs.modal', () => {
        editFotoFiles = [];
        editFotoUrls.forEach(url => URL.revokeObjectURL(url));
        editFotoUrls = [];
        editFotoInput.value = '';
        editFotoPreview.src = '';
        editFotoPreview.style.display = 'none';
        editFotoPlaceholder.style.display = 'flex';
        window.editExistingPhotos = [];
        window.editNewPhotoUrls = [];
        window.editPhotoIndex = 0;
        updateEditGallery();
    });

    const editForm = document.getElementById('formEditMobil');
    if (editForm) {
        editForm.querySelectorAll('.harga-display').forEach(input => {
            input.addEventListener('input', function () {
                const digits = normalizePriceValue(this.value);
                this.value = digits ? formatPriceDisplay(digits) : '';
                const valueField = this.closest('form').querySelector('.harga-value');
                if (valueField) valueField.value = digits;
                const preview = this.closest('form').querySelector('#editPreviewHarga');
                if (preview) preview.textContent = formatPriceLabel(digits);
            });
        });

        editForm.addEventListener('submit', function () {
            const display = this.querySelector('.harga-display');
            const value = this.querySelector('.harga-value');
            if (display && value) value.value = normalizePriceValue(display.value);
        });
    }
});