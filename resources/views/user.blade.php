<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Promosi Mobil - Showroom Kendaraan Terpercaya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<!-- NAVBAR DENGAN LOGO -->
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-logo" onclick="scrollToSection('beranda')">
            <div class="logo-text">
                <span class="logo-title">AutoShow</span>
                <span class="logo-subtitle">Premium Vehicles</span>
            </div>
        </div>
        <div class="nav-menu">
            <a href="#beranda" class="nav-link" onclick="scrollToSection('beranda'); return false;">Beranda</a>
            <a href="#katalog" class="nav-link" onclick="scrollToSection('katalog'); return false;">Katalog</a>
            <a href="#tentang" class="nav-link" onclick="scrollToSection('tentang'); return false;">Tentang</a>
            <a href="#kontak" class="nav-link" onclick="scrollToSection('kontak'); return false;">Kontak</a>
            <a href="{{ route('admin.login') }}" class="nav-link admin-link">👨‍💼 Admin</a>

        </div>
    </div>
</nav>

<div class="container">
    <header id="beranda">
        <h1>🚗 Promosi Mobil 2025</h1>
        <p>Pilihan Terbaik Untuk Kendaraan Impian Anda</p>
    </header>

    <!-- SECTION KATALOG -->
    <section id="katalog" class="section">
    <h2 class="section-title">📋 Katalog Mobil</h2>
    <div class="mobil-list">

        @foreach($mobils as $m)
        <div class="mobil-card">
            <div class="mobil-info">
                <img src="{{ asset('storage/' . $m->foto) }}" alt="{{ $m->nama_mobil }}">
            </div>

            <div class="mobil-detail">
                <div class="detail-row">
                    <span class="detail-label">SERI:</span>
                    <span class="detail-value">{{ $m->seri }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama:</span>
                    <span class="detail-value">{{ $m->nama_mobil }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Merek:</span>
                    <span class="detail-value">{{ $m->merek }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Harga:</span>
                    <span class="detail-value">Rp {{ number_format($m->harga, 0, ',', '.') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Stok:</span>
                    <span class="detail-value">{{ $m->stok }} Unit</span>
                </div>
            </div>

            <div class="mobil-action">
                <button class="btn-detail"
                    data-id="{{ $m->seri }}"
                    data-nama="{{ $m->nama_mobil }}"
                    data-merek="{{ $m->merek }}"
                    data-harga="Rp {{ number_format($m->harga, 0, ',', '.') }}">
                    📋 Detail
                </button>

                <button class="btn-beli"
                    onclick="openModalPembelian('{{ $m->nama_mobil }}')"
                    data-id="{{ $m->seri }}"
                    data-nama="{{ $m->nama_mobil }}"
                    data-harga="Rp {{ number_format($m->harga, 0, ',', '.') }}">
                    🛒 Beli
                </button>
            </div>
        </div>
        @endforeach

    </div>
</section>

    <!-- SECTION TENTANG -->
    <section id="tentang" class="section">
        <h2 class="section-title">ℹ️ Tentang Kami</h2>
        <div class="about-content">
            <div class="about-text">
                <h3>AutoShow - Solusi Kendaraan Premium Anda</h3>
                <p>Dengan pengalaman lebih dari 10 tahun di industri otomotif, AutoShow berkomitmen memberikan pelayanan terbaik dan kendaraan berkualitas tinggi.</p>
                <p>Kami menawarkan berbagai pilihan mobil dari merek ternama dengan harga kompetitif dan cicilan yang fleksibel.</p>
                <div class="about-features">
                    <div class="feature-item">✓ Mobil Original & Bergaransi</div>
                    <div class="feature-item">✓ Cicilan Ringan Hingga 7 Tahun</div>
                    <div class="feature-item">✓ Trade-In / Tukar Tambah</div>
                    <div class="feature-item">✓ Test Drive Gratis</div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION KONTAK -->
    <section id="kontak" class="section">
        <h2 class="section-title">📞 Hubungi Kami</h2>
        <div class="contact-content">
            <div class="contact-info">
                <div class="contact-item">
                    <h4>📍 Lokasi</h4>
                    <p>Jl. Merdeka No.123, Jakarta, Indonesia</p>
                </div>
                <div class="contact-item">
                    <h4>📞 Telepon</h4>
                    <p>+62 851 9116 3819</p>
                </div>
                <div class="contact-item">
                    <h4>📧 Email</h4>
                    <p>info@autoshow.com</p>
                </div>
                <div class="contact-item">
                    <h4>⏰ Jam Operasional</h4>
                    <p>Senin - Jumat: 08:00 - 18:00<br>Sabtu: 09:00 - 17:00<br>Minggu: Tutup</p>
                </div>
            </div>
        </div>
    </section>

</div>


<!-- MODAL BELI -->
<!-- ========== MODAL FORM BELI ========== -->
<div id="formModal" id="formPembelian" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeForm()">&times;</span>
        <h2>📝 Formulir Pembelian Kendaraan</h2>

        <form id="pembelianForm" class="form-grid" method="POST" action="{{ route('pembelian.store') }}">
    @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="telepon" required>
            </div>

            <div class="form-group">
                <label>Kota</label>
                <input type="text" name="kota" required>
            </div>

            <div class="form-group full">
                <label>Alamat</label>
                <textarea name="alamat" required></textarea>
            </div>

            <div class="form-group full" style="margin-top:10px;">
            <button type="submit" style="background-color: #6f42c1; color: white; border: none; padding: 10px; width: 100%; cursor: pointer;">
    KIRIM PEMBELIAN
</button>
            </div>
        </form>
    </div>
</div>
<!-- ========== END MODAL ========== -->


<!-- MODAL DETAIL -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <span class="close-detail">&times;</span>
        <h2 id="detailNama"></h2>
        <p><strong>Merek:</strong> <span id="detailMerek"></span></p>
        <p><strong>Harga:</strong> <span id="detailHarga"></span></p>
        <p><strong>Mesin:</strong> <span id="detailMesin"></span></p>
        <p><strong>Transmisi:</strong> <span id="detailTransmisi"></span></p>
        <p><strong>Bahan Bakar:</strong> <span id="detailBahan"></span></p>
        <p><strong>CC:</strong> <span id="detailCc"></span></p>
        <p><strong>Warna:</strong> <span id="detailWarna"></span></p>
        <p><strong>Tahun:</strong> <span id="detailTahun"></span></p>
        <p><strong>Penggerak:</strong> <span id="detailPenggerak"></span></p>
    </div>
</div>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>🚗 AutoShow</h3>
            <p>Penyedia kendaraan premium terpercaya dengan pelayanan terbaik untuk kebutuhan transportasi Anda.</p>
            <div class="social-links">
                <a href="#" class="social-icon" title="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>

        <div class="footer-section">
            <h4>Kategori</h4>
            <ul>
                <li><a href="#">Mobil Keluarga</a></li>
                <li><a href="#">Mobil Mewah</a></li>
                <li><a href="#">Mobil Sport</a></li>
                <li><a href="#">Mobil Komersial</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Layanan</h4>
            <ul>
                <li><a href="#">Test Drive</a></li>
                <li><a href="#">Cicilan</a></li>
                <li><a href="#">Tukar Tambah</a></li>
                <li><a href="#">Asuransi</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Hubungi Kami</h4>
            <ul>
                <li>📞 +62 851 9116 3819</li>
                <li>📧 info@autoshow.com</li>
                <li>📍 Jl. Merdeka No.123</li>
                <li>🏢 Jakarta, Indonesia</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 AutoShow. All rights reserved. | Privacy Policy | Terms of Service</p>
    </div>
</footer>

<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/pembelian.js') }}"></script>
</body>
</html>
