<?php
    require './vendor/autoload.php';

    //ENV Stuff
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $apiUrl = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=" . $_ENV['API_KEY'];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => '{
         "client": {
            "clientId": "URLChecker",
            "clientVersion": "1.1.1.1"   
         },
         "threatInfo": {
            "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING"],
            "platformTypes":    ["WINDOWS"],
            "threatEntryTypes": ["URL"],
            "threatEntries": [
              {"url": "google.com"}
              
            ]
          } 
        }',
        CURLOPT_HTTPHEADER => array(
            "cache-control: no cache",
            "Content-Type: application/json",
            
            
        ),
        
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if($err){
        echo "error: " . $err;
    } else {
        echo $response;
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URLChecker</title>
</head>
<body>
    <div>
        <h1>URL Checker</h1>
        
    </div>
</body>
</html>