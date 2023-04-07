<?php 
    $url = 'http://192.168.1.18:3000/api/admin/login';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
    "Accept: application/json",
    "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $data = <<<DATA
    {
    "username": "dexter",
    "password": "dexter"
    }
    DATA;

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $resp = curl_exec($curl);
    curl_close($curl);
    
    $result = json_decode($resp, true);

    $url = "http://192.168.1.18:3000/api/hooks?token={$result['token']}";
    $result = file_get_contents($url, false);
    
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
                    <h1>BeEF Hooked Browser</h1>
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
    
    <div class=" my-5">
        <div class="row">
            <div class="col-12 col-md-12"> 
                    <div class='table-responsive'>
                        
                        <table class='table table-bordered' > 
                                                
                        <thead class="thead-light">   
                        <tr><th>Status</th><th>ID</th><th>Session</th><th>Platform</th><th>OS</th><th>Hardware</th><th>IP</th><th>Domain</th><th>Port</th><th>Page URI</th><th>First Seen</th><th>Last Seen</th><th>Date Stamp</th><th>City</th><th>Country</th><th>Country Code</th></tr>                                                
                        </thead>
                        <tbody>
                            
                        <?php
                        $result = json_decode($result, true);
                        foreach ($result['hooked-browsers']['online'] as $row){
                            echo "<tr>";
                            echo "<td>Online</td>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['session'] . "</td>";
                            echo "<td>" . $row['platform'] . "</td>";
                            echo "<td>" . $row['os'] . "</td>";
                            echo "<td>" . $row['hardware'] . "</td>";
                            echo "<td>" . $row['ip'] . "</td>";
                            echo "<td>" . $row['domain'] . "</td>";
                            echo "<td>" . $row['port'] . "</td>";
                            echo "<td>" . $row['page_uri'] . "</td>";
                            echo "<td>" . date("Y-m-d H:i:s",$row['firstseen']) . "</td>";
                            echo "<td>" . date("Y-m-d H:i:s",$row['lastseen']) . "</td>";
                            echo "<td>" . $row['date_stamp'] . "</td>";
                            echo "<td>" . $row['city'] . "</td>";
                            echo "<td>" . $row['country'] . "</td>";
                            echo "<td>" . $row['country_code'] . "</td>";

                        }
                        foreach ($result['hooked-browsers']['offline'] as $row){
                                echo "<tr>";
                                echo "<td>Offline</td>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['session'] . "</td>";
                                echo "<td>" . $row['platform'] . "</td>";
                                echo "<td>" . $row['os'] . "</td>";
                                echo "<td>" . $row['hardware'] . "</td>";
                                echo "<td>" . $row['ip'] . "</td>";
                                echo "<td>" . $row['domain'] . "</td>";
                                echo "<td>" . $row['port'] . "</td>";
                                echo "<td>" . $row['page_uri'] . "</td>";
                                echo "<td>" . date("Y-m-d H:i:s",$row['firstseen']) . "</td>";
                                echo "<td>" . date("Y-m-d H:i:s",$row['lastseen']) . "</td>";
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
