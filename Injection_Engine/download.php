<?php

// check if the file exists
$file = "User_SVG/".$_COOKIE['file'];
if (!file_exists($file)) {
    die("File not found.");
}
else{
    
    // get the file size
    $filesize = filesize($file);

    // set the headers
    header("Content-Type: image/svg+xml");
    header("Content-Disposition: attachment; filename={$_COOKIE['file']}");
    header("Content-Length: ".$filesize);

    // read the file and output it
    readfile($file);
}

?>


