// Cari semua pesan kesalahan dengan kelas error-message
var errorMessages = document.querySelectorAll('.error-message');

// Loop melalui setiap pesan kesalahan
errorMessages.forEach(function (errorMessage) {
    // Tentukan waktu (dalam milidetik) sebelum pesan kesalahan dihapus
    var timeoutDuration = 5000; // Misalnya, 5000 milidetik (5 detik)

    // Set timeout untuk menghapus pesan kesalahan setelah waktu tertentu
    setTimeout(function () {
        errorMessage.remove(); // Menghapus pesan kesalahan dari DOM
    }, timeoutDuration);
});

// Fungsi untuk menampilkan SweetAlert dan menangani penghapusan grup
function confirmDelete(event, groupId) {
    // Mencegah perilaku default dari link
    event.preventDefault();
    // Mencegah penyebaran event ke elemen lain, seperti card
    event.stopPropagation();

    // Menampilkan SweetAlert dengan ID grup yang terkait
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this group!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'No, cancel',
        reverseButtons: false, // Menukar posisi tombol konfirmasi dan pembatalan
        confirmButtonColor: '#dc3545' // Ubah warna tombol konfirmasi di sini
    }).then((result) => {
        if (result.isConfirmed) {
            // Alihkan ke URL penghapusan dengan ID yang sesuai
            window.location.href = '/groups/' + groupId + '/delete';
        }
    });
}

// Menambahkan event listener untuk setiap tombol delete
document.addEventListener('DOMContentLoaded', function () {
    var deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            // Mendapatkan ID grup dari atribut data
            var groupId = button.getAttribute('data-group-id');

            // Memanggil fungsi confirmDelete dengan event dan ID grup
            confirmDelete(event, groupId);
        });
    });

    // Membersihkan state JavaScript saat halaman dimuat kembali dari cache
    window.addEventListener('pageshow', function (event) {
        deleteButtons.forEach(function (button) {
            button.removeEventListener('click', confirmDelete);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const workTypeSelect = document.getElementById('exampleInputWorkType1');
    const imageUpload = document.getElementById('imageUpload');

    workTypeSelect.addEventListener('change', function() {
        if (this.value === 'WFH') {
            imageUpload.style.display = 'block';
        } else {
            imageUpload.style.display = 'none';
        }
    });

    document.getElementById('checkInButton').addEventListener('click', function(e) {
        document.getElementById('attendanceForm').submit();
    });

    document.getElementById('checkOutButton').addEventListener('click', function(e) {
        document.getElementById('checkOutForm').submit();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const workTypeSelect = document.getElementById('workTypeSelect');
    const imageUploadSection = document.getElementById('imageUploadSection');
    const currentImageSection = document.getElementById('currentImageSection');

    function toggleImageSections() {
        if (workTypeSelect.value === 'WFH') {
            imageUploadSection.style.display = 'flex';
            currentImageSection.style.display = 'none';
        } else {
            imageUploadSection.style.display = 'none';
            currentImageSection.style.display = 'none';
        }
    }

    function showInitialImageSection() {
        if (workTypeSelect.value === 'WFH' && currentImageSection.querySelector('img')) {
            currentImageSection.style.display = 'block';
        } else {
            currentImageSection.style.display = 'none';
        }
    }

    workTypeSelect.addEventListener('change', toggleImageSections);

    showInitialImageSection();
});