$(document).ready(function() {
    $('#uploadForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'uploading.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response)
                var responseData = JSON.parse(response);
                if (responseData.status === 'success') {
                    // Handle success response
                    console.log(responseData.message);
                    // Display success message or perform any other action
                } else {
                    // Handle error response
                    console.error(responseData.message);
                    // Display error message or perform any other action
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: ", error);
                // Handle AJAX error
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});
