document.addEventListener('DOMContentLoaded', function () {
document.querySelectorAll('.alert-close').forEach(function (button) {
    button.addEventListener('click', function () {
        var alertBox = button.closest('.alert-box2');
        if (alertBox) {
            alertBox.remove();
        }
    });
});

document.querySelectorAll('.alert-box2').forEach(function (alertBox) {
    setTimeout(function () {
        if (alertBox && alertBox.parentNode) {
            alertBox.remove();
        }
    }, 5000);
});

$('#editDataModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    if (!button.length) {
        return;
    }
    $('#edit-id').val(button.data('id'));
    $('#edit-nama').val(button.data('nama'));
    $('#edit-npm').val(button.data('npm'));
    $('#edit-prodi').val(button.data('prodi'));
    $('#edit-angkatan').val(button.data('angkatan'));
});

$('#deleteDataModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    if (!button.length) {
        return;
    }
    var nama = button.data('nama') || 'ini';
    $('#delete-id').val(button.data('id'));
    $('#delete-nama').val(nama);
    $('#delete-name').text(nama);
});
});