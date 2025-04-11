// tambah ini untuk menggunakan sweetalert (untuk popup pesan dari backend)

document.addEventListener('DOMContentLoaded', function () {
    const alertElement = document.getElementById('sweetalert-data');
    if (!alertElement) return;

    const type = alertElement.dataset.type;
    const message = alertElement.dataset.message;

    if (type && message) {
        Swal.fire({
            icon: type,
            title: getTitle(type),
            text: message,
            timer: type === 'success' ? 2500 : undefined,
            showConfirmButton: type !== 'success'
        });
    }

    function getTitle(type) {
        switch (type) {
            case 'success': return 'Berhasil';
            case 'error': return 'Gagal';
            case 'info': return 'Info';
            case 'warning': return 'Peringatan';
            default: return '';
        }
    }
});

