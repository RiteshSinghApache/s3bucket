<?php
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require 'vendor/autoload.php'; // Include the SDK using Composer autoloader

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// Set your AWS credentials
$client = S3Client::factory([
    'credentials' => array(
        'key' => 'S3key',
        'secret' => 's3secretid',
    ),
    'region'  => 'ap-south-1', // dont forget to set the region
    'version' => 'latest',
]);
$response = array();
$bucketName = isset($_POST['bucket_name']) ? $_POST['bucket_name'] : "bucket_name";
$filePathInBucket = isset($_POST['file_path_in_bucket']) ? $_POST['file_path_in_bucket'] : "";
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";die;
if (!empty($_FILES['file'])) {

    try {
        
        $result = $client->putObject([
            'Bucket' => $bucketName,
            'Key' => $filePathInBucket,
            'Body' => fopen($_FILES['file']['tmp_name'], 'rb'),
            'ACL' => 'private', // Set the ACL to private
        ]);
        
        if ($result) {
            $response = array('status' => 'success', 'message' => 'File uploaded successfully!', 'filedata' => $result['ObjectURL']) ;
        }else{
            $response = array('status' => 'error', 'message' => 'Failed to upload file to S3');
        }
        
    } catch (Exception $e) {
        $response = array('status' => 'error', 'message' => $e->getMessage());
    }

}else{
    $response = array('status' => 'error', 'message' => 'File not found!!');
}

$json_response = json_encode($response);
echo $json_response;
exit();
?>
