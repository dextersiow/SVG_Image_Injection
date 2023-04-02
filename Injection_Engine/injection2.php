<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SVG Image Injection Tool</title>
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
                                    <a class="nav-link" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contact</a>
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
            <div class="col-12 col-md-6"> 
                <!-- choose inject option form  -->
                <form action="injection.php" method="post">      
                    <div class="form-group">
                        <p>Please choose options for payload injection:</p>
                        <div class="form-check">
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
                    
                    <div class="form-group">
                        <p>Choose an element to be inserted after:</p>
                        <select class='form-select' name='element' required ></select>
                        <?php 
                        if(isset($elements)){
                            echo "<select class='form-select' name='element' >";
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
                            <p>BeEF</p>
                        </div>

                        <div class="mb-3 opt xml ">
                             <p> Proceed with XML Bomb</p>
                        </div>

                        <div class="mb-3 opt htmlInj ">
                            <p>Proceed with HTML injection</p>
                        </div>

                        <div class="mb-3 opt xss ">
                            <p>Proceed with XSS</p>
                        </div>

                        <div class="mb-3 opt user_input ">
                            <label class="form-label" for="BeEF">Provide payload to be injected:</label>
                            <input type="text" class="form-control" name="manual_payload">
                        </div>

                        <input type="submit" class="btn btn-secondary opt sub
                        " value="Submit" name="payload_submit">
                        <input type="submit" class="btn btn-secondary" value="Cancel" name="cancel">
                    </div>
                </form>
                <!-- download svg -->
                <a href="download.php"><button class="btn btn-primary">Download SVG</button></a>
            </div>
        </div>
        <div class="row">
                <div class='col-sm-6'>
                    <h3>SVG Image embed in IMG tag</h3>
                    <img src="<?php echo "User_SVG/".$_COOKIE['file'] ?>"><br>
                </div>
                
                
                <div class='col-sm-6'>
                    <h3>SVG Image rendered directly</h3>
                    <?php echo "<iframe width='800' height='600' srcdoc='".file_get_contents("User_SVG/".$_COOKIE['file'])."'></iframe>";?>
                </div>
                
                <h3>SVG XML</h3>
                <?php 
                    if(isset($svgContent)){
                        echo htmlspecialchars($svgContent)."<br>";
                    }
                ?>  
        </div>
    </div>
</body>
</html>