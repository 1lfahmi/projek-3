document.addEventListener('DOMContentLoaded', function () {

    /* ================= KONFIGURASI WHATSAPP ================= */
    // Ganti dengan nomor WhatsApp Anda (format internasional tanpa +)
    const WHATSAPP_NUMBER = '6285191163819'; // Contoh: 6281234567890

    /* ================= NAVIGATION ================= */
    window.scrollToSection = function(sectionId) {
        document.querySelectorAll('.section').forEach(sec => sec.classList.remove('active'));

        const target = document.getElementById(sectionId);
        if (target && target.classList.contains('section')) {
            target.classList.add('active');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    };

    // Default tampil katalog
    const katalog = document.getElementById('katalog');
    if (katalog) katalog.classList.add('active');


    /* ================= MODAL ELEMENTS ================= */
    const formModal   = document.getElementById('formModal');
    const detailModal = document.getElementById('detailModal');
    const userForm    = document.getElementById('userForm');
    const mobilIdInput = document.getElementById('mobilId');
    const mobilNamaInput = document.getElementById('mobilNama');
    const mobilHargaInput = document.getElementById('mobilHarga');

    const closeFormBtn   = document.querySelector('.close');
    const closeDetailBtn = document.querySelector('.close-detail');
    const cancelBtn      = document.getElementById('cancelBtn');

    const detailFields = {
        nama: document.getElementById('detailNama'),
        merek: document.getElementById('detailMerek'),
        harga: document.getElementById('detailHarga'),
        mesin: document.getElementById('detailMesin'),
        transmisi: document.getElementById('detailTransmisi'),
        bahanbakar: document.getElementById('detailBahan'),
        cc: document.getElementById('detailCc'),
        warna: document.getElementById('detailWarna'),
        tahun: document.getElementById('detailTahun'),
        penggerak: document.getElementById('detailPenggerak')
    };

    const openModal = (modal) => {
        if (!modal) return;
        modal.classList.add('show');
        modal.style.display = 'flex';
    };

    const closeModal = (modal) => {
        if (!modal) return;
        modal.classList.remove('show');
        modal.style.display = 'none';
    };


    /* ================= OPEN MODAL BELI ================= */
    document.querySelectorAll('.btn-beli').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Simpan data mobil yang dipilih
            if (mobilIdInput) mobilIdInput.value = this.dataset.id;
            if (mobilNamaInput) mobilNamaInput.value = this.dataset.nama;
            if (mobilHargaInput) mobilHargaInput.value = this.dataset.harga;
            
            openModal(formModal);
        });
    });


    /* ================= OPEN MODAL DETAIL ================= */
    document.querySelectorAll('.btn-detail').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            Object.keys(detailFields).forEach(key => {
                if (detailFields[key]) {
                    detailFields[key].innerText = this.dataset[key] || '-';
                }
            });

            openModal(detailModal);
        });
    });


    /* ================= CLOSE MODAL HANDLERS ================= */
    if (closeFormBtn) {
        closeFormBtn.onclick = function(e) {
            e.preventDefault();
            closeModal(formModal);
        };
    }

    if (closeDetailBtn) {
        closeDetailBtn.onclick = function(e) {
            e.preventDefault();
            closeModal(detailModal);
        };
    }

    if (cancelBtn) {
        cancelBtn.onclick = function(e) {
            e.preventDefault();
            closeModal(formModal);
        };
    }

    // Close modal when clicking outside
    window.onclick = function (e) {
        if (formModal && e.target === formModal) {
            closeModal(formModal);
        }
        if (detailModal && e.target === detailModal) {
            closeModal(detailModal);
        }
    };


   /* ================= KIRIM KE LARAVEL DULU ================= */
if (userForm) {
    userForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = new FormData(userForm);

        fetch("/beli-mobil", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            window.open(data.target_url, "_blank"); // buka WA dari Laravel
            userForm.reset();
            closeModal(formModal);
        })
        .catch(err => {
            console.error(err);
            alert("❌ Gagal kirim data ke server");
        });
    });
}


});  