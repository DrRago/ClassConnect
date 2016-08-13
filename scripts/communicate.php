<?php
function getContent($data, $path) {
    $curl = curl_init();

    // set options
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://dqi.tandashi.de/API/' . $path, // required
        CURLOPT_RETURNTRANSFER => true, // required for correct json_encoded output
        CURLOPT_TIMEOUT => 10,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data // required if POST-Option is set to 'true'
    ));

    return(curl_exec($curl));
}