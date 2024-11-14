<?php
/*
echo '<pre>';
print_r(json_decode(wp_remote_retrieve_body(wp_remote_get('https://api.open-meteo.com/v1/forecast?latitude=48.9757&longitude=14.4803&current=temperature_2m&daily=weather_code,temperature_2m_max,temperature_2m_min,sunrise,sunset,uv_index_max&timezone=Europe%2FBerlin'))));
echo '</pre>';
*/
$cities = [
    [
        "city" => "Praha",
        "latitude" => "50.0755",
        "longitude" => "14.4378"
    ],
    [
        "city" => "Brno",
        "latitude" => "49.1951",
        "longitude" => "16.6068"
    ],
    [
        "city" => "Plzen",
        "latitude" => "49.7384",
        "longitude" => "13.3736"
    ],
    [
        "city" => "Hradec_Kralove",
        "latitude" => "50.0752",
        "longitude" => "15.7835"
    ],
    [
        "city" => "Pardubice",
        "latitude" => "50.2116",
        "longitude" => "15.8312"
    ],
    [
        "city" => "Ustí_nad_Labem",
        "latitude" => "50.1109",
        "longitude" => "14.4795"
    ],
    [
        "city" => "Ostrava",
        "latitude" => "49.8419",
        "longitude" => "18.2927"
    ],
    [
        "city" => "Zlin",
        "latitude" => "49.2235",
        "longitude" => "17.6689"
    ],
    [
        "city" => "Karlovy_Vary",
        "latitude" => "49.7333",
        "longitude" => "13.3700"
    ],
    [
        "city" => "Liberec",
        "latitude" => "50.7767",
        "longitude" => "15.0564"
    ],
    [
        "city" => "Jihlava",
        "latitude" => "49.2264",
        "longitude" => "16.5961"
    ],
    [
        "city" => "Ceske_Budejovice",
        "latitude" => "49.4465",
        "longitude" => "15.2135"
    ],
    [
        "city" => "Olomouc",
        "latitude" => "49.1986",
        "longitude" => "17.7036"
    ]
];

fetch_weather_data ($cities);

/*
$data = [
'current_temperature' => 25,
'forecast' => [21, 22, 23, 24, 25, 26, 27],
'sunrise' => '06:30',
'sunset' => '18:45',
];
update_option('weather_data_2024_11_13', $data);
*/