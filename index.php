<!DOCTYPE html>
<html>
    <head>
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >

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
            <div class="col-12 col-md-6"> 
                <form action="injection.php" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label for="svgimage" class="form-label"><h3>Select Image to upload:</h3></label>
                        <input class="form-control" type="file" id="svgimage" name="SVGToUpload" required>                        
                    </div>
                    <input class="btn btn-primary" type="submit" value="Submit Image" name="svg_submit">
                </form>
            </div>
        </div>
    </div>


</body>
</html>
