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
    const formModal   = document.getElementById('formModal');
    const detailModal = document.getElementById('detailModal');
    const userForm    = document.getElementById('userForm');
    const mobilIdInput = document.getElementById('mobilId');
    const mobilNamaInput = document.getElementById('mobilNama');
    const mobilHargaInput = document.getElementById('mobilHarga');

    const closeFormBtn   = document.querySelector('.close');
    const closeDetailBtn = document.querySelector('.close-detail');
    const cancelBtn      = document.getElementById('cancelBtn');

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


    /* ================= WHATSAPP INTEGRATION ================= */
    if (userForm) {
        userForm.onsubmit = function(e) {
            e.preventDefault();

            // Ambil data dari form
            const nama = document.querySelector('input[name="nama"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const telepon = document.querySelector('input[name="telepon"]').value;
            const kota = document.querySelector('input[name="kota"]').value;
            const alamat = document.querySelector('textarea[name="alamat"]').value;
            
            // Data mobil yang dipilih
            const mobilNama = mobilNamaInput ? mobilNamaInput.value : '-';
            const mobilHarga = mobilHargaInput ? mobilHargaInput.value : '-';
            const mobilId = mobilIdInput ? mobilIdInput.value : '-';

            // Format pesan WhatsApp
            const message = `
🚗 *PEMBELIAN MOBIL BARU*
━━━━━━━━━━━━━━━━━━━━

📋 *INFORMASI MOBIL*
• Nama Mobil: ${mobilNama}
• Seri: ${mobilId}
• Harga: ${mobilHarga}

👤 *DATA PEMBELI*
• Nama: ${nama}
• Email: ${email}
• Telepon: ${telepon}
• Kota: ${kota}
• Alamat: ${alamat}

━━━━━━━━━━━━━━━━━━━━
Terima kasih telah memesan mobil di AutoShow! 🎉
            `.trim();

            // Encode pesan untuk URL WhatsApp
            const encodedMessage = encodeURIComponent(message);
            
            // URL WhatsApp API
            const whatsappURL = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodedMessage}`;
            
            // Buka WhatsApp di tab baru
            window.open(whatsappURL, '_blank');
            
            // Reset form dan tutup modal
            setTimeout(() => {
                userForm.reset();
                closeModal(formModal);
                alert('✅ Form berhasil dikirim! Silakan lanjutkan di WhatsApp.');
            }, 500);

            return false;
        };
    }

});