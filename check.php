<?php

    require './vendor/autoload.php';

    //ENV Stuff
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    class checkURL{
        public $threatType;
        public $platformType; 
        public $maliciousUrl;
        public $threatEntryType;
    }
    function performCheck($url){
        $result = new checkUrl();
        $threatTypes = ['MALWARE', 'SOCIAL_ENGINEERING'];
        //$apiUrl = "https://postb.in/1639115674637-2233810471370";
        
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
            'threatEntries' =>['url' => $url] 
            ]
    ];
        $encodedFields = json_encode($postFields, JSON_UNESCAPED_SLASHES);
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $encodedFields,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0,
                
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
                
                
            ),
            
        );

        $response = curl_exec($curl);
        
        $err = curl_error($curl);
        if($err){
            echo "error: " . $err;
        } else {
            if($response){
                //echo '<br><br>Response: <br> <br>' . $response;
                
                $r = json_decode($response, true);
                if(empty($r)) {
                    $result->threatType = "None";
                    $result->platformType = "None";
                    $result->maliciousUrl = $threatUrl;
                    $result->threatEntryType = "None";
                } else {
                    $result->threatType = $r['matches'][0]['threatType'];
                    $result->platformType = $r['matches'][0]['platformType'];
                    $result->maliciousUrl = $r['matches'][0]['threat']['url'];
                    $result->threatEntryType = $r['matches'][0]['threatEntryType'];

                }
            }   
        }
        curl_close($curl);
        return $result;
        }
?>