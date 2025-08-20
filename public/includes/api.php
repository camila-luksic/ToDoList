<?php

const API_URL = 'http://localhost:8081/todoApp/public/todos';

function callAPI($method, $url, $data = null) {
    $curl = curl_init();
    $headers = ['Content-Type: application/json'];

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    switch (strtoupper($method)) {
        case 'POST':
            curl_setopt($curl, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
            break;
        case 'PUT':
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
            break;
        case 'DELETE':
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;
        case 'GET':
            break;
        default:
            throw new Exception("Método HTTP no soportado: $method");
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
        curl_close($curl);
        throw new Exception("Error cURL: $error_msg");
    }
    
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_code >= 400) {
        $response_data = json_decode($result, true);
        $error_message = $response_data['message'] ?? "La API devolvió un código de error: $http_code";
        throw new Exception($error_message);
    }

    return json_decode($result, true);
}