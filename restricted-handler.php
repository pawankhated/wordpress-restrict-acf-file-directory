<?php

// Custom PHP script to handle directory restriction logic

// Check if the request is coming from the correct directory
$requested_file = $_SERVER['REQUEST_URI'];
$restricted_directory = '/wp-content/uploads/restricted_directory/';
if (strpos($requested_file, $restricted_directory) !== false) {
    // Custom logic to check access permission
    // For example, check if the user is logged in or has appropriate permissions
    // Replace this with your own logic
    session_start();
    if (!isset($_SESSION['mtloggedin'])) {
        header("HTTP/1.1 403 Forbidden");
        echo '<div id="container">
        <section class="error content background-wrap cloud-blue">            
                <h1 class="title title--regular title--size-large title--weight-bold">403 - Forbidden</h1>
                <p class="title title--subtitle title--size-semimedium title--weight-normal">Access to this page is forbidden.</p>
          
        </section>
    </div>';
        exit;
    }
}

// Serve the requested file
$file_path = $_SERVER['DOCUMENT_ROOT'] . $requested_file;
if (file_exists($file_path)) {
    // Output file content
    header('Content-Type: ' . mime_content_type($file_path));
    readfile($file_path);
} else {
    // File not found
    header("HTTP/1.1 404 Not Found");
    echo "File not found";
}
