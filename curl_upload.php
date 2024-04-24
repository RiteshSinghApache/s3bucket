<?php
error_reporting(E_ALL);

// Configuration
$bucketName = "bucketName";
$uploadUrl = "curl_uploading.php";
$uploadDir = 'uploads/';

// Check if file is uploaded
if (!isset($_FILES['file'])) {
    echo "Error: No file uploaded.";
    exit;
}

$tmp_name_punjabi = $_FILES['file']['tmp_name'];
$fileType = $_FILES['file']['type'];

// Validate file type
$allowedTypes = ['image/jpeg', 'image/png' ]; // Add more allowed types if needed
if (!in_array($fileType, $allowedTypes)) {
    echo "Error: Invalid file type.";
    exit;
}

// Generate unique file name
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$name_punjabi = md5(uniqid(mt_rand())).'.'.$extension;
$filepath = $uploadDir . $name_punjabi;

// Create destination directory if it doesn't exist
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        echo "Error: Failed to create directory.";
        exit;
    }
}

// //Move uploaded file to destination directory
if (!move_uploaded_file($tmp_name_punjabi, $filepath)) {
    echo "Error: Failed to move uploaded file.";
    exit;
}

// Perform cURL request to upload file to remote server
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uploadUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'bucket_name' => $bucketName,
    'file_path_in_bucket' => $filepath,
    'file' => new CURLFile($filepath)
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close($ch);
// Handle cURL response
$response = json_decode($server_output);
if ($response === null) {
    echo "Error: " . curl_error($ch);
    unlink($filepath);
} 
else {
    print_r($response);
}
?>
