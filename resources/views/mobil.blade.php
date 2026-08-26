@extends('admin.admin') 

@section('main-content')
<div class="card shadow border-0 rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Data Mobil</h5>
        <button class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalTambahMobil">
            <i class="fas fa-plus me-1"></i> Tambah Mobil
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Seri</th>
                        <th>Nama Mobil</th>
                        <th>Merek</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mobils as $m)
                    <tr>
                        <td>
                                @if($m->foto && Illuminate\Support\Facades\Storage::exists($m->foto[0] ?? null))
                                    <img src="{{ Storage::url($m->foto[0]) }}" width="70" class="rounded shadow-sm">
                                @else
                                    <img src="https://via.placeholder.com/70x50?text=No+Pic" width="70" class="rounded shadow-sm" alt="No image">
                                @endif
                        </td>
                        <td><span class="badge bg-secondary">{{ $m->seri }}</span></td>
                        <td>{{ $m->nama_mobil }}</td>
                        <td>{{ $m->merek }}</td>
                        <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                        <td>{{ $m->stok }}</td>
                        <td>
                            @if(isset($m->status) && $m->status === 'sold')
                                <span class="badge bg-danger">Terbeli</span>
                            @elseif(isset($m->status) && $m->status === 'reserved')
                                <span class="badge bg-warning text-dark">Sedang Diproses</span>
                            @else
                                <span class="badge bg-success">Tersedia</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm text-white" onclick="editMobil('{{ $m->id }}')">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            
                            @if(isset($m->status) && $m->status === 'sold')
                                <form action="{{ route('mobil.setAvailable', $m->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-info">Set Tersedia</button>
                                </form>
                            @endif

                            <form action="{{ route('mobil.destroy', $m->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data mobil di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahMobil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('mobil.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <div><h5 class="modal-title fw-bold mb-1">Tambah Kendaraan</h5><small>Lengkapi spesifikasi kendaraan sebelum disimpan</small></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <h6 class="fw-bold text-primary border-bottom pb-2">Identitas Kendaraan</h6>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Seri</label><input type="text" name="seri" class="form-control" placeholder="#MB001" required></div>
                                <div class="col-md-6"><label class="form-label">Tahun</label><input type="number" name="tahun" class="form-control" min="1900" placeholder="2025"></div>
                                <div class="col-md-6"><label class="form-label">Nama Mobil</label><input type="text" name="nama_mobil" class="form-control" placeholder="Contoh: Toyota Alphard" required></div>
                                <div class="col-md-6"><label class="form-label">Merek</label><input type="text" name="merek" class="form-control" placeholder="Contoh: Toyota" required></div>
                                <div class="col-md-6"><label class="form-label">Harga</label><input type="text" name="harga_display" class="form-control harga-display" inputmode="numeric" placeholder="250.000.000" autocomplete="off" required><input type="hidden" name="harga" class="harga-value"></div>
                                <div class="col-md-6"><label class="form-label">Stok</label><input type="number" name="stok" class="form-control" min="1" placeholder="1" required></div>
                            </div>
                            <h6 class="fw-bold text-primary border-bottom pb-2 mt-4">Spesifikasi Mesin</h6>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Mesin</label><input type="text" name="mesin" class="form-control" placeholder="Contoh: 2.5L Hybrid"></div>
                                <div class="col-md-6"><label class="form-label">CC</label><input type="number" name="cc" class="form-control" min="1" placeholder="2500"></div>
                                <div class="col-md-6"><label class="form-label">Transmisi</label><select name="transmisi" class="form-select"><option value="">Pilih transmisi</option><option>Automatic</option><option>Manual</option><option>CVT</option></select></div>
                                <div class="col-md-6"><label class="form-label">Bahan Bakar</label><select name="bahan_bakar" class="form-select"><option value="">Pilih bahan bakar</option><option>Bensin</option><option>Diesel</option><option>Hybrid</option><option>Listrik</option></select></div>
                                <div class="col-md-6"><label class="form-label">Warna</label><input type="text" name="warna" class="form-control" placeholder="Contoh: Putih Mutiara"></div>
                                <div class="col-md-6"><label class="form-label">Penggerak</label><select name="penggerak" class="form-select"><option value="">Pilih penggerak</option><option>FWD</option><option>RWD</option><option>4WD</option><option>AWD</option></select></div>
                            </div>
                        </div>
                        <div class="col-lg-5"><div class="preview-panel"><h6 class="fw-bold text-primary">Preview Kendaraan</h6><div class="vehicle-preview mb-3" id="tambahGallery"><img id="tambahFotoPreview" src="" alt="Preview foto mobil"><div id="tambahFotoPlaceholder"><i class="fas fa-image"></i><span>Foto akan tampil di sini</span></div><button type="button" class="gallery-arrow gallery-arrow-prev" id="tambahFotoPrev" aria-label="Foto sebelumnya"><i class="fas fa-chevron-left"></i></button><button type="button" class="gallery-arrow gallery-arrow-next" id="tambahFotoNext" aria-label="Foto berikutnya"><i class="fas fa-chevron-right"></i></button></div><div class="gallery-dots" id="tambahFotoDots"></div><label class="form-label">Foto Kendaraan</label><input type="file" name="foto[]" id="tambahFoto" class="form-control" accept="image/*" multiple required><small class="text-muted d-block mt-2">Pilih beberapa foto sekaligus dengan Ctrl + klik, maksimal 5 foto.</small><small class="text-muted d-block" id="tambahFotoCount">Belum ada foto dipilih.</small><div class="preview-summary mt-4"><div class="fw-bold mb-2" id="previewNama">Nama kendaraan</div><div><span id="previewMerek">Merek</span><span id="previewTahun">Tahun</span></div><strong id="previewHarga">Rp 0</strong></div></div></div>
                    </div>
                </div>
                <div class="modal-footer p-4"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Simpan Kendaraan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditMobil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <form id="formEditMobil" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header bg-primary text-white">
                    <div><h5 class="modal-title fw-bold mb-1">Edit Data Mobil</h5><small>Perbarui spesifikasi kendaraan sebelum disimpan</small></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <h6 class="fw-bold text-primary border-bottom pb-2">Identitas Kendaraan</h6>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Seri</label><input type="text" name="seri" id="edit_seri" class="form-control" required></div>
                                <div class="col-md-6"><label class="form-label">Tahun</label><input type="number" name="tahun" id="edit_tahun" class="form-control" min="1900"></div>
                                <div class="col-md-6"><label class="form-label">Nama Mobil</label><input type="text" name="nama_mobil" id="edit_nama" class="form-control" required></div>
                                <div class="col-md-6"><label class="form-label">Merek</label><input type="text" name="merek" id="edit_merek" class="form-control" required></div>
                                <div class="col-md-6"><label class="form-label">Harga</label><input type="text" name="harga_display" id="edit_harga" class="form-control harga-display" inputmode="numeric" autocomplete="off" required><input type="hidden" name="harga" id="edit_harga_value" class="harga-value"></div>
                                <div class="col-md-6"><label class="form-label">Stok</label><input type="number" name="stok" id="edit_stok" class="form-control" required></div>
                            </div>

                            <h6 class="fw-bold text-primary border-bottom pb-2 mt-4">Spesifikasi Mesin</h6>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Mesin</label><input type="text" name="mesin" id="edit_mesin" class="form-control"></div>
                                <div class="col-md-6"><label class="form-label">CC</label><input type="number" name="cc" id="edit_cc" class="form-control" min="1"></div>
                                <div class="col-md-6"><label class="form-label">Transmisi</label><select name="transmisi" id="edit_transmisi" class="form-select"><option value="">Pilih transmisi</option><option>Automatic</option><option>Manual</option><option>CVT</option></select></div>
                                <div class="col-md-6"><label class="form-label">Bahan Bakar</label><select name="bahan_bakar" id="edit_bahan_bakar" class="form-select"><option value="">Pilih bahan bakar</option><option>Bensin</option><option>Diesel</option><option>Hybrid</option><option>Listrik</option></select></div>
                                <div class="col-md-6"><label class="form-label">Warna</label><input type="text" name="warna" id="edit_warna" class="form-control"></div>
                                <div class="col-md-6"><label class="form-label">Penggerak</label><select name="penggerak" id="edit_penggerak" class="form-select"><option value="">Pilih penggerak</option><option>FWD</option><option>RWD</option><option>4WD</option><option>AWD</option></select></div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="preview-panel">
                                <h6 class="fw-bold text-primary">Preview Kendaraan</h6>
                                <div class="vehicle-preview mb-3" id="editGallery">
                                    <img id="editFotoPreview" src="" alt="Preview foto mobil">
                                    <div id="editFotoPlaceholder"><i class="fas fa-image"></i><span>Foto akan tampil di sini</span></div>
                                    <button type="button" class="gallery-arrow gallery-arrow-prev" id="editFotoPrev" aria-label="Foto sebelumnya"><i class="fas fa-chevron-left"></i></button>
                                    <button type="button" class="gallery-arrow gallery-arrow-next" id="editFotoNext" aria-label="Foto berikutnya"><i class="fas fa-chevron-right"></i></button>
                                </div>
                                <div class="gallery-dots" id="editFotoDots"></div>
                                <label class="form-label">Ganti Gambar</label>
                                <input type="file" name="foto[]" id="editFotoInput" class="form-control" accept="image/*" multiple>
                                <small class="text-muted d-block mt-2">Pilih 1 sampai 5 gambar baru. Foto lama akan diganti seluruhnya.</small>
                                <div class="preview-summary mt-4">
                                    <div class="fw-bold mb-2" id="editPreviewNama">Nama kendaraan</div>
                                    <div><span id="editPreviewMerek">Merek</span><span id="editPreviewTahun">Tahun</span></div>
                                    <strong id="editPreviewHarga">Rp 0</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-4">
                    <button type="submit" class="btn btn-primary px-4 w-100"><i class="fas fa-save me-2"></i>Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/mobil.js') }}"></script>
<script>
    const tambahForm = document.querySelector('#modalTambahMobil form');
    const fotoInput = document.getElementById('tambahFoto');
    const fotoPreview = document.getElementById('tambahFotoPreview');
    const fotoPlaceholder = document.getElementById('tambahFotoPlaceholder');
    const tambahGallery = document.getElementById('tambahGallery');
    const tambahFotoDots = document.getElementById('tambahFotoDots');
    const tambahFotoPrev = document.getElementById('tambahFotoPrev');
    const tambahFotoNext = document.getElementById('tambahFotoNext');
    const tambahFotoCount = document.getElementById('tambahFotoCount');
    let tambahFotoFiles = [];
    let tambahFotoUrls = [];
    let tambahFotoIndex = 0;

    function resetTambahFoto() {
        tambahFotoUrls.forEach(url => URL.revokeObjectURL(url));
        tambahFotoFiles = [];
        tambahFotoUrls = [];
        tambahFotoIndex = 0;
        fotoInput.value = '';
        tambahFotoCount.textContent = 'Belum ada foto dipilih.';
        updateTambahGallery();
    }

    function syncTambahFotoInput() {
        const transfer = new DataTransfer();
        tambahFotoFiles.forEach(file => transfer.items.add(file));
        fotoInput.files = transfer.files;
    }

    function updateTambahGallery() {
        const hasPhotos = tambahFotoUrls.length > 0;
        fotoPreview.src = hasPhotos ? tambahFotoUrls[tambahFotoIndex] : '';
        fotoPreview.style.display = hasPhotos ? 'block' : 'none';
        fotoPlaceholder.style.display = hasPhotos ? 'none' : 'flex';
        tambahGallery.classList.toggle('has-gallery', tambahFotoUrls.length > 1);
        tambahFotoDots.innerHTML = tambahFotoUrls.map((url, index) => `<button type="button" class="gallery-dot ${index === tambahFotoIndex ? 'active' : ''}" aria-label="Foto ${index + 1}"></button>`).join('');
        tambahFotoDots.querySelectorAll('.gallery-dot').forEach((dot, index) => {
            dot.addEventListener('click', () => {
                tambahFotoIndex = index;
                updateTambahGallery();
            });
        });
    }

    if (fotoInput) {
        fotoInput.addEventListener('change', function () {
            tambahFotoUrls.forEach(url => URL.revokeObjectURL(url));
            const files = Array.from(this.files || []);
            const totalFiles = tambahFotoFiles.length + files.length;
            if (totalFiles > 5) {
                alert('Maksimal 5 foto yang dapat dipilih.');
            } else {
                tambahFotoFiles = tambahFotoFiles.concat(files);
            }
            syncTambahFotoInput();
            tambahFotoUrls = tambahFotoFiles.map(file => URL.createObjectURL(file));
            tambahFotoCount.textContent = tambahFotoFiles.length ? `${tambahFotoFiles.length} foto dipilih.` : 'Belum ada foto dipilih.';
            tambahFotoIndex = 0;
            updateTambahGallery();
        });
    }
    tambahFotoPrev.addEventListener('click', () => {
        if (tambahFotoUrls.length > 1) {
            tambahFotoIndex = (tambahFotoIndex - 1 + tambahFotoUrls.length) % tambahFotoUrls.length;
            updateTambahGallery();
        }
    });
    tambahFotoNext.addEventListener('click', () => {
        if (tambahFotoUrls.length > 1) {
            tambahFotoIndex = (tambahFotoIndex + 1) % tambahFotoUrls.length;
            updateTambahGallery();
        }
    });
    document.getElementById('modalTambahMobil').addEventListener('hidden.bs.modal', () => {
        tambahForm.reset();
        resetTambahFoto();
        document.getElementById('previewNama').textContent = 'Nama kendaraan';
        document.getElementById('previewMerek').textContent = 'Merek';
        document.getElementById('previewTahun').textContent = 'Tahun';
        document.getElementById('previewHarga').textContent = 'Rp 0';
        tambahForm.querySelector('.harga-value').value = '';
    });
    if (tambahForm) {
        tambahForm.querySelector('[name="nama_mobil"]').addEventListener('input', e => document.getElementById('previewNama').textContent = e.target.value || 'Nama kendaraan');
        tambahForm.querySelector('[name="merek"]').addEventListener('input', e => document.getElementById('previewMerek').textContent = e.target.value || 'Merek');
        tambahForm.querySelector('[name="tahun"]').addEventListener('input', e => document.getElementById('previewTahun').textContent = e.target.value || 'Tahun');
        tambahForm.querySelector('[name="harga_display"]').addEventListener('input', e => document.getElementById('previewHarga').textContent = e.target.value ? `Rp ${e.target.value}` : 'Rp 0');
    }
    document.querySelectorAll('.harga-display').forEach(input => {
        input.addEventListener('input', function () {
            const digits = this.value.replace(/\D/g, '');
            this.value = digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '';
            this.closest('form').querySelector('.harga-value').value = digits;
        });
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
            const display = form.querySelector('.harga-display');
            const value = form.querySelector('.harga-value');
            if (display && value) value.value = display.value.replace(/\D/g, '');
        });
    });
</script>
<style>
    #modalTambahMobil .modal-dialog { max-width: 1120px; width: calc(100% - 32px); height: calc(100% - 2rem); margin: 1rem auto; }
    #modalTambahMobil .modal-content { border-radius: 0 !important; height: 100%; max-height: none; overflow: hidden; }
    #modalTambahMobil form { min-height: 0; height: 100%; display: flex; flex-direction: column; }
    #modalTambahMobil .modal-header { border-radius: 0 !important; }
    #modalTambahMobil .modal-header,
    #modalTambahMobil .modal-footer { flex: 0 0 auto; }
    #modalTambahMobil .modal-body { flex: 1 1 auto; min-height: 0; overflow-y: auto !important; overflow-x: hidden; scrollbar-width: auto; scrollbar-color: #facc15 #061530; }
    #modalTambahMobil .modal-body::-webkit-scrollbar { width: 12px; }
    #modalTambahMobil .modal-body::-webkit-scrollbar-track { background: #061530; }
    #modalTambahMobil .modal-body::-webkit-scrollbar-thumb { background: #facc15; border: 2px solid #061530; }
    #modalEditMobil .modal-dialog { max-width: 1120px; width: calc(100% - 32px); height: calc(100% - 2rem); margin: 1rem auto; }
    #modalEditMobil .modal-content { border-radius: 0 !important; height: 100%; max-height: none; overflow: hidden; }
    #modalEditMobil form { min-height: 0; height: 100%; display: flex; flex-direction: column; }
    #modalEditMobil .modal-header { border-radius: 0 !important; }
    #modalEditMobil .modal-header,
    #modalEditMobil .modal-footer { flex: 0 0 auto; }
    #modalEditMobil .modal-body { flex: 1 1 auto; min-height: 0; overflow-y: auto !important; overflow-x: hidden; scrollbar-width: auto; scrollbar-color: #facc15 #061530; }
    #modalEditMobil .modal-body::-webkit-scrollbar { width: 12px; }
    #modalEditMobil .modal-body::-webkit-scrollbar-track { background: #061530; }
    #modalEditMobil .modal-body::-webkit-scrollbar-thumb { background: #facc15; border: 2px solid #061530; }
    #modalEditMobil .modal-header,
    #modalEditMobil .modal-footer .btn-primary { background: #facc15 !important; color: #061530 !important; }
    #modalEditMobil .modal-header small,
    #modalEditMobil .modal-header .btn-close { color: #061530 !important; }
    #modalEditMobil .modal-header .btn-close { filter: none; opacity: 0.8; }
    #modalEditMobil h6.text-primary,
    #modalEditMobil .form-label { color: #facc15 !important; }
    #modalEditMobil h6.text-primary { border-color: #facc15 !important; }
    #modalEditMobil .preview-panel { border-color: #facc15; }
    #modalEditMobil .preview-summary { border-left-color: #facc15; }
    #modalEditMobil .preview-summary strong { color: #b77900; }
    #modalEditMobil .modal-footer { border-top: 1px solid #facc15 !important; }
    #modalTambahMobil .preview-panel,
    #modalTambahMobil .vehicle-preview,
    #modalTambahMobil .preview-summary,
    #modalTambahMobil .form-control,
    #modalTambahMobil .form-select,
    #modalEditMobil .preview-panel,
    #modalEditMobil .vehicle-preview,
    #modalEditMobil .preview-summary,
    #modalEditMobil .form-control,
    #modalEditMobil .form-select { border-radius: 0 !important; }
    #modalTambahMobil .modal-footer {
        border: 0 !important;
        background: transparent !important;
        border-radius: 0 !important;
        padding: 1rem 1.5rem 0.75rem !important;
    }
    @media (max-width: 768px) {
        #modalTambahMobil .modal-dialog { width: calc(100% - 16px); height: calc(100% - 1rem); margin: 8px auto; }
        #modalEditMobil .modal-dialog { width: calc(100% - 1rem); height: calc(100vh - 1rem); max-height: calc(100vh - 1rem); margin: 8px auto; }
        #modalTambahMobil .modal-footer { padding: 0.75rem 1rem 0.5rem !important; }
    }
    .preview-panel { background: #f8fafc; border: 1px solid #dee2e6; border-radius: 16px; padding: 20px; height: 100%; }
    .vehicle-preview { aspect-ratio: 16 / 10; background: #e9ecef; border: 2px dashed #adb5bd; border-radius: 14px; display: flex; align-items: center; justify-content: center; overflow: hidden; color: #6c757d; }
    .vehicle-preview img { display: none; width: 100%; height: 100%; object-fit: cover; }
    .vehicle-preview { position: relative; }
    .vehicle-preview .gallery-arrow { display: none; position: absolute; top: 50%; transform: translateY(-50%); z-index: 2; width: 36px; height: 36px; padding: 0; border: 0; border-radius: 50%; background: rgba(13, 110, 253, 0.9); color: #fff; }
    .vehicle-preview .gallery-arrow-prev { left: 12px; }
    .vehicle-preview .gallery-arrow-next { right: 12px; }
    .vehicle-preview.has-gallery .gallery-arrow { display: inline-flex; align-items: center; justify-content: center; }
    .gallery-dots { display: flex; justify-content: center; gap: 6px; min-height: 10px; margin: -2px 0 12px; }
    .gallery-dot { width: 8px; height: 8px; border: 0; border-radius: 50%; padding: 0; background: #cbd5e1; }
    .gallery-dot.active { background: #0d6efd; }
    #tambahFotoPlaceholder, #editFotoPlaceholder { display: flex; flex-direction: column; align-items: center; gap: 8px; font-size: 0.9rem; }
    #tambahFotoPlaceholder i, #editFotoPlaceholder i { font-size: 2.4rem; color: #94a3b8; }
    .preview-summary { background: #ffffff; border-left: 4px solid #0d6efd; border-radius: 10px; padding: 14px; color: #1e293b; }
    .preview-summary > div:nth-child(2) { display: flex; justify-content: space-between; color: #64748b; font-size: 0.85rem; margin-bottom: 12px; }
    .preview-summary strong { color: #0d6efd; font-size: 1.25rem; }
    #editFotoPreview { display: none; }
    /* Ensure action buttons are visible and usable on small screens */
    @media (max-width: 768px) {
        .table-responsive .table td { white-space: normal; }
        .table-responsive .table td .btn, .table-responsive .table td button {
            display: inline-block !important;
            min-width: 36px;
            margin-right: 6px;
            margin-bottom: 6px;
        }
        .table-responsive .table td .btn i { margin-right: 6px; }
        .table-responsive { overflow-x: auto; }
    }

    /* Make the action buttons slightly larger so they're easier to tap */
    .btn-edit, .btn-del, .table-responsive .btn-sm {
        min-width: 40px;
        height: 38px;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection