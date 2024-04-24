<?php
require 'vendor/autoload.php'; // Include the SDK using Composer autoloader

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// Set your AWS credentials
$client = S3Client::factory([
    'key' => 'S3key',
    'secret' => 's3secretid',
]);

try {
    // Specify the bucket name and file path
    $bucketName = 'bucketName';
    $filePathInBucket = 'bharat.txt'; // Adjust this as needed

    // Upload the file
    $client->putObject([
        'Bucket' => $bucketName,
        'Key' => $filePathInBucket,
        'SourceFile' => 'C:\Users\HP\Desktop\bharat.txt', // Local file path
        'StorageClass' => 'REDUCED_REDUNDANCY', // Optional storage class
        'ACL' => 'private', // Set the ACL to private
    ]);

    echo 'File uploaded successfully!';
} catch (S3Exception $e) {
    echo 'Error uploading file: ' . $e->getMessage();
}
?>
