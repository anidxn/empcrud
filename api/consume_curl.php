<?php
/*
Majorly 2 options are there to consume an api using PHP
1. file_get_contents()
2. CURL()
*/

$url = 'http://127.0.0.1:8085/api/v1/companies/';

// 2. using curl

// Initialize a curl session handle
//curl_session_hndl = curl_init($url);
// OR
$curl_session_hndl = curl_init();





$opcode = "";
if(isset($_GET['OP'])){
    $opcode = $_GET['OP'];
}

switch($opcode){
    case "GET":

        /*
        // Set the url as an option
        curl_setopt($curl_session_hndl, CURLOPT_URL, $url);
        //return the response as a string
        curl_setopt($curl_session_hndl, CURLOPT_RETURNTRANSFER, true);
        */

        //or pass an array
        curl_setopt_array($curl_session_hndl, 
        [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true

        ]);

    break;

    case "POST":
        $payload = json_encode([
                "name"      => "Sony",
                "location"  => "South Korea",
                "about"     => "Imaging device manufacturer",
                "type"      => "IT",
                "added_date"=> "2024-07-1T11:11:43.763947Z",
                "active"    => true            
        ]);

        $headers = [
            "Content-type: application/json; charset=UTF-8",
            "Accept-language: en"
        ];

        curl_setopt_array($curl_session_hndl, 
            [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => $headers

            ]);
    break;

    case "PUT":
    break;
    case "PATCH":
    break;
    case "DELETE":
    break;
}


$response = curl_exec($curl_session_hndl);

curl_close($curl_session_hndl);

var_dump($response);


?>