<?php

function get_request($url, $params = NULL) {
    $ch = curl_init();

    if ($params !== NULL && !empty($params)){
        $url .= '?';
        foreach($params as $key => $value) {
            $url .= $key . '=' . curl_escape($ch, $value) . '&';
        }
        $url = rtrim($url, '&');
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,
                CURLOPT_HTTPHEADER,
                array('Accept: application/json',
                      'Authorization: Basic YThkYWI1ZmUtN2E0Ny00YzE3LTg0ZWEtNDZmYWNiN2QxOWZl'));
    $result = curl_exec($ch);
    if ($result === false) { $result = curl_error($ch); }
    $json = json_decode($result);
    curl_close($ch);
    return $json;
}

function post_raw($url, $body) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch,
                CURLOPT_HTTPHEADER,
                array('Content-Type: text/plain',
                      'Accept: application/json',
                      'Authorization: Basic YThkYWI1ZmUtN2E0Ny00YzE3LTg0ZWEtNDZmYWNiN2QxOWZl'));
    $result = curl_exec($ch);
    if ($result === false) { $result = curl_error($ch); }
    $json = json_decode($result);
    curl_close($ch);
    return $json;     
}

function russian_demo() {
    $base_url = 'https://ws3.morpher.ru';
    
    echo "Склонение на русском языке:\r\n";
    $russian_declension = get_request("{$base_url}/russian/declension", ['s' => 'Соединенного королевства']);
    print_r($russian_declension);
    
    echo "Склонение с признаками:\r\n";
    $russian_declension_with_flags = get_request("{$base_url}/russian/declension", ['s' => 'Саша Пархоменко',
                                                                                    'flags' => 'feminine,name']);
    print_r($russian_declension_with_flags);
    
    echo "Пропись чисел и согласование с числом:\r\n";
    $spell_result = get_request("{$base_url}/russian/spell", ['n' => '253',
                                                              'unit' => 'рубль']);
    print_r($spell_result);
    
    echo "Склонение прилагательных по родам:\r\n";
    $genders = get_request("{$base_url}/russian/genders", ['s' => 'уважаемый']);
    print_r($genders);
    
    echo "Функция образования прилагательных:\r\n";
    $adjectivize = get_request("{$base_url}/russian/adjectivize", ['s' => 'Мытищи']);
    print_r($adjectivize);    
    
    echo "Расстановка ударений в текстах:\r\n";
    $accentizer = post_raw("{$base_url}/russian/addstressmarks", 'Балет Петра Чайковского "Щелкунчик"');
    print_r($accentizer);
    echo "\r\n";
}

function ukrainian_demo(){
    $base_url = 'https://ws3.morpher.ru';
    
    echo "Склонение на украинском языке:\r\n";
    $ukrainian_declension = get_request("{$base_url}/ukrainian/declension", ['s' => 'Крутько Катерина Володимирiвна']);
    print_r($ukrainian_declension);
    
    echo "Пропись чисел и согласование с числом:\r\n";
    $spell_result = get_request("{$base_url}/ukrainian/spell", 
        ['n' => '253',
        'unit' => 'рубль']);
    print_r($spell_result);
}

$base_url = 'https://ws3.morpher.ru';
russian_demo();
ukrainian_demo();

$requests_left = get_request("{$base_url}/get_queries_left_for_today");
echo "Остаток запросов на день: {$requests_left}"
?>

