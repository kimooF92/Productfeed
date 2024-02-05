$(document).ready(function() {
    $('#typeSelect').change(function() {
        var type = $(this).val();
        var baseUrl = $('#xmlUrl').val();
        var modifiedUrl = baseUrl;
        if (type === 'Products') {
            modifiedUrl = baseUrl + '/sitemap/products_01.xml';
        } else if (type === 'Pages') {
            modifiedUrl = baseUrl + '/sitemap/pages_01.xml';
        }
        $('#xmlUrl').val(modifiedUrl);
    });

    $('#xmlForm').submit(function(event) {
        event.preventDefault();
        var xmlUrl = $('#xmlUrl').val();
        $.ajax({
            url: 'process.php', // This is where you will send the form data for processing
            type: 'POST',
            data: { xmlUrl: xmlUrl },
            success: function(data) {
                // Assuming `data` contains the HTML for the table rows
                $('#dataTable').html(data);
            }
        });
    });
});
