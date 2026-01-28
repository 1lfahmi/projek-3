document.addEventListener('DOMContentLoaded', function () {
    const userForm = document.getElementById('userForm');

    if (userForm) {
        userForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Mencegah pindah halaman/WA

            const formData = new FormData(this);
            // Ambil token dari meta tag yang ada di head
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("/beli-mobil", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert("Pesanan Berhasil! Data sudah masuk ke sistem.");
                document.getElementById('formModal').style.display = 'none'; // Tutup modal
                userForm.reset(); // Kosongkan form
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Gagal mengirim data.");
            });
        });
    }
});