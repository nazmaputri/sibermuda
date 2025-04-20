// javascript untuk konfirmasi penghapusan data menggunakan sweetalert, dipakai di semua halaman yang ada button hapus dengan class btn-delete

document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".btn-delete");

    deleteButtons.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const form = btn.closest("form");

            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                customClass: {
                    popup: 'text-sm',
                    confirmButton: 'bg-green-400 hover:bg-green-300 text-white rounded-sm px-4 py-2 mx-2',
                    cancelButton: 'bg-red-400 hover:bg-red-300 text-white rounded-sm px-4 py-2 mx-2'
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

