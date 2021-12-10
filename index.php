<?php
    require './vendor/autoload.php';
    require './check.php';
    //ENV Stuff
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    

    if(isset($_GET['url'])){
        $check = performCheck($_GET['url']);
        $threatType = $check->threatType;
        $platformType = $check->platformType;
        $threatEntryType = $check->threatEntryType;
        $maliciousUrl = $check->maliciousUrl;
    } else {
        ?>
        <style type="text/css">.pure-group{
        display:none;
        }</style>
    <?php
    }
    //echo $response['matches'][0]['threatType'];  
    
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URLChecker</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/pure-min.css" integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="check-containter">
        <h1>URL Checker</h1>
            
                <form action="/" method="GET" class="pure-form">
                    <input type="text" name="url" class="pure-input-2-3" placeholder="e.g., https://google.com" />
                    <button type="submit" class="pure-button pure-button-primary">Submit</button>
                </form>
        <div class="pure-group">
                <p>Threat type:  <?= $threatType; ?></p>
                <p>Platform type: <?= $platformType ?> </p>
                <p>Threat Entry Type: <?= $threatEntryType ?></p>
                <p>Threat URL: <?= $maliciousUrl ?></p>
        </div>
    </div>
</body>
</html>