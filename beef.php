<?php 
$url = 'http://192.168.1.18:3000/api/hooks?token=0e543068f08b874802c37cea2ec0338ed385096e';
$result = file_get_contents($url, false);
if ($result === FALSE) { /* Handle error */ }
?>

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
                    <h1>BeEF</h1>
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
                                    <a class="nav-link" href="#">BeEF</a>
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
            <div class="col-12 col-md-12"> 
                <h3>Hooked Browser:</h3>
                    <div class='table-responsive'>
                        
                        <table class='table table-bordered' > 
                                                
                        <thead class="thead-light">   
                        <tr><th>ID</th><th>Session</th><th>Platform</th><th>OS</th><th>Hardware</th><th>IP</th><th>Domain</th><th>Port</th><th>Page URI</th><th>First Seen</th><th>Last Seen</th><th>Date Stamp</th><th>City</th><th>Country</th><th>Country Code</th></tr>                                                
                        </thead>
                        <tbody>
                            
                        <?php
                        $result = json_decode($result, true);
                         foreach ($result['hooked-browsers']['offline'] as $row){
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['session'] . "</td>";
                                echo "<td>" . $row['platform'] . "</td>";
                                echo "<td>" . $row['os'] . "</td>";
                                echo "<td>" . $row['hardware'] . "</td>";
                                echo "<td>" . $row['ip'] . "</td>";
                                echo "<td>" . $row['domain'] . "</td>";
                                echo "<td>" . $row['port'] . "</td>";
                                echo "<td>" . $row['page_uri'] . "</td>";
                                echo "<td>" . $row['firstseen'] . "</td>";
                                echo "<td>" . $row['lastseen'] . "</td>";
                                echo "<td>" . $row['date_stamp'] . "</td>";
                                echo "<td>" . $row['city'] . "</td>";
                                echo "<td>" . $row['country'] . "</td>";
                                echo "<td>" . $row['country_code'] . "</td>";

                            }
                        ?>
                        
                        </tbody>
                        </table>

                    </div>
            </div>
        </div>
    </div>


</body>
</html>
