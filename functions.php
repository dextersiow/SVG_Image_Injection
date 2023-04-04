<?php
function inject_into_svg($svg, $payload, $tag) {
    $svg = str_split($svg); 
    for ($buffer = 0; $buffer < sizeof($svg); $buffer++) {
        if ($svg[$buffer] == '<' && $svg[$buffer+1] == $tag[0]) {
            $found = true;
            for ($j = 0; $j < strlen($tag); $j++) {
                if ($svg[$buffer + $j + 1] != $tag[$j]) {
                    $found = false;
                    break;
                }
            }
            if ($found) {
                // find close bracket after finding the tag
                $i = 0;
                do {
                    $i++;
                } while ($svg[$buffer + $i] != ">");
                // position to insert is at 1 index after the close bracket
                $position = $buffer + $i + 1;
                break;
            }
        }
    }
    array_splice($svg, $position, 0, $payload);
    return implode($svg);
}


function delete_img_cookie(){
    unlink("User_SVG/".$_COOKIE['file']);
    setcookie("file", "", time()-3600);
    setcookie("xml", "", time()-3600);
    unset($_COOKIE['file']);
    unset($_COOKIE['xml']);
}

//get all svg element in an svg
function findallelements($svg){
    $element='';
    $elemets_arry=array();
    $svg = str_split($svg); 
    //loop through whole array
    for($buffer=0;$buffer<sizeof($svg);$buffer++){
        //check on open bracket
        if($svg[$buffer]=='<' && (ctype_alpha($svg[$buffer+1]) || $svg[$buffer+1] == '/' || $svg[$buffer+1] == '?' || $svg[$buffer+1] == '!')){
            //loop until next space
            for ($i = $buffer + 1; ctype_alpha($svg[$i]) || is_numeric($svg[$i]) || $svg[$i] == '/' || $svg[$i] == '?' || $svg[$i] == '!'; $i++){
                //get all character which form an element
                $element.=$svg[$i];
            };
            array_push($elemets_arry,$element);
            $element='';
        }

    }
    return array_unique($elemets_arry, SORT_STRING);
}

function uploadImage($fileupload, $target_dir){
    
        if($fileupload["error"]!=4){
            $target_file = $target_dir . basename($fileupload["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.<br>";
                $uploadOk = 0;
            }
            
            // Check file size
            if ($fileupload["size"] > 500000) {
                echo "Sorry, your file is too large.<br>";
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if($imageFileType != "svg" ) {
                echo "Sorry, only SVG files are allowed.<br>";
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
            } else {
                // if everything is ok, try to upload file
                if (move_uploaded_file($fileupload["tmp_name"], $target_file)) {
                echo "<script>alert('The file ". htmlspecialchars( basename( $fileupload["name"])). " has been uploaded.')</script>";
                setcookie("file",basename($fileupload["name"]));
                return  true;
                } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
                }
            }
        }
        else{
            return false;
        }
    
}

?>