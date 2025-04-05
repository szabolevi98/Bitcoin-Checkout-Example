$('#txForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'index.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (data) {
            $('#result').html(`
                <div class="alert ${data.success ? 'alert-success' : 'alert-danger'} mt-3 mb-0">
                    ${data.message}
                </div>
            `);
        },
        error: function (xhr, status, error) {
            console.error('Hiba történt:', error.message);
            $('#result').html(`
                <div class="alert alert-danger mt-3 mb-0">Unexpected error happened. Please contact support.</div>
            `);
        }
    });
});
