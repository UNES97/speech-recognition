<?php

include 'vars.php';
$apiKey = GOOGLE_API_KEY;
$audioFile = 'demo-audio.mp3';
$apiUrl = 'https://speech.googleapis.com/v1/speech:recognize';

$data = array(
    'config' => array(
        'encoding' => 'MP3',
        'sampleRateHertz' => 16000,
        'languageCode' => 'ar-MA',
    ),
    'audio' => array(
        'content' => base64_encode(file_get_contents($audioFile)),
    ),
);

$jsonData = json_encode($data);
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $apiUrl . '?key=' . $apiKey,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $jsonData,
));

$response = curl_exec($curl);
var_dump($response);exit;
if (curl_errno($curl)) {
    echo 'Error: ' . curl_error($curl);
} 
else {
    $responseData = json_decode($response, true);
    if (isset($responseData['results'][0]['alternatives'][0]['transcript'])) 
    {
        $transcription = $responseData['results'][0]['alternatives'][0]['transcript'];
        echo 'Transcription: ' . $transcription;
    } 
    else {
        echo 'No transcription found.';
    }
}
curl_close($curl);
?>
