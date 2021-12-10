<?php
    require './vendor/autoload.php';

    //ENV Stuff
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $threatTypes = ['MALWARE', 'SOCIAL_ENGINEERING'];
    //$apiUrl = "https://postb.in/1639115674637-2233810471370";
    //$threatUrl = "http://live-transaction-times-ing.trycloudflare.com/login.html";
    $threatUrlTest = "http://malware.testing.google.test/testing/malware/*";
    $threatUrl = "https://google.com";
    $apiUrl = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=" . $_ENV['API_KEY'];
    //$postfields = array ('client' => array('clientId' => 'URLChecker', 'clientVersion' => '1.1.1.1'), 'threatInfo' => array('threatTypes' => $threatTypes, 'platformTypes' => '[WINDOWS]', 'threatEntryTypes' =>  '[URL]', 'threatEntries' => array('url' => $threatUrl)));
    $postFields = ['client' => 
        ['clientId' => "URLChecker",
         'clientVersion' => '1.1.1.1', ],
          'threatInfo' => ['threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
         'platformTypes' => ['WINDOWS'],
         'threatEntryTypes' => ['URL'],
         'threatEntries' =>['url' => $threatUrlTest] 
         ]
];
    $encodedFields = json_encode($postFields, JSON_UNESCAPED_SLASHES);
    echo $encodedFields;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
        
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $encodedFields,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HEADER => 1,
            
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
            
            
        ),
        
    );

    $response = curl_exec($curl);
    $err = curl_error($curl);
    if($err){
        echo "error: " . $err;
    } else {
        if($response){
            echo '<br><br>Response: <br> <br>' . $response;
            $res = json_decode($response);

           // echo $res['matches'];
            echo '<br> Test: <br> ' . $res[0];            
        }   
    }
    curl_close($curl);

    
    

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