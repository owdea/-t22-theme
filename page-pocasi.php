<?php
get_header();
setlocale(LC_TIME, 'cs_CZ.UTF-8');
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
        "city" => "Usti_nad_Labem",
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
$fetched_data = fetch_weather_data($cities);
$max_temperatures = $fetched_data["avg_max_temperatures"];
$min_temperatures = $fetched_data["avg_min_temperatures"];
$avg_sunrise_times = $fetched_data["avg_sunrise_times"];
$avg_sunset_times = $fetched_data["avg_sunset_times"];
$avg_weather_codes = $fetched_data["avg_weather_codes"];
?>
<div class="weather-page">
    <h2>
        Počasí v České republice
    </h2>
    <div class="weather-days-row">
        <?php
        for ($i = 0; $i < 7; $i++) {
            echo '<div class="weather-day" >';
                echo '<button class="weather-button-'.$i + 1 .'">';
                    echo '<div class="weather-day-top-row">';
                        echo '<span>';
                        if ($i == 0) echo "DNES";
                        else if ($i == 1) echo "ZÍTRA";
                        else echo mb_strtoupper(strftime('%A', strtotime("+$i day")), 'UTF-8');
                        echo '</span>';
                        echo '<span>';
                        echo strftime('%e. %m.', strtotime("+$i day"));
                        echo '</span>';
                    echo '</div>';
                    echo '<div class="weather-day-bottom-row">';
                        echo '<div class="weather-day-temperature">';
                            echo "<span>" . $max_temperatures[$i] . "°</span>";
                            echo "<span>/";
                            echo $min_temperatures[$i] . "°</span>";
                        echo "</div>";
                    echo '</div>';
                echo '</button>';
            echo '</div>';
        }
        ?>
    </div>

    <div class="weather-map">
        <div class="weather-selected-day-container">
            <div class="weather-selected-day-day">
                <div class="weather-selected-day-day-info-col">
                    <span>DEN</span>
                    <?php
                    for ($i = 0; $i < 7; $i++) {
                        echo '<span class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">'. $max_temperatures[$i] .'°</span>';
                    }
                    ?>
                </div>
                <div class="weather-selected-day-day-info-img">
                    <?php
                    for ($i = 0; $i < 7; $i++) {
                        echo '<div class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">';
                        echo '<img src="' . get_template_directory_uri() . get_weather_category_by_code($fetched_data['cities_data']['Praha']->daily->weather_code[$i]) . '">';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="weather-selected-day-sun-events">
                <div class="weather-sunrise-time">
                    <img src="<?php echo get_template_directory_uri()?>/assets/icons/weather-sunrise.svg">
                <?php
                for ($i = 0; $i < 7; $i++) {
                    echo '<span class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">'. $avg_sunrise_times[$i] .'</span>';

                }
                ?>
                    <span>Východ</span>
                </div>
                <div class="weather-sunset-time">
                    <img src="<?php echo get_template_directory_uri()?>/assets/icons/weather-sunset.svg">
                    <?php
                    for ($i = 0; $i < 7; $i++) {
                        echo '<span class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">'. $avg_sunset_times[$i] .'</span>';

                    }
                    ?>
                    <span>Západ</span>
                </div>
            </div>
            <div class="weather-selected-day-night">
                <div class="weather-selected-day-night-info-col">
                    <span>NOC</span>
                    <?php
                    for ($i = 0; $i < 7; $i++) {
                        echo '<span class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">'. $max_temperatures[$i] .'°</span>';
                    }
                    ?>
                </div>
                <div class="weather-selected-day-night-info-img">
                <?php
                for ($i = 0; $i < 7; $i++) {
                    echo '<div class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">';
                    echo '<img src="' . get_template_directory_uri() . get_weather_category_by_code($fetched_data['cities_data']['Praha']->daily->weather_code[$i]) . '">';
                    echo '</div>';
                }
                ?>
                </div>
            </div>
        </div>
        <div class="weather-overlay-selected-data">
            <?php
            foreach ($cities as $city) {
                $city_name = $city['city'];

                if (isset($fetched_data['cities_data'][$city_name])) {
                    $city_data = $fetched_data['cities_data'][$city_name];

                    echo '<div class="city-weather-'.$city_name.' city-weather-forecast">';
                        echo "<div class='city-weather-forecast-top'>";
                            for ($i = 0; $i < 7; $i++) {
                                echo '<div class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">';
                                echo '<img src="' . get_template_directory_uri() . get_weather_category_by_code($city_data->daily->weather_code[$i]) . '">';
                                echo '</div>';
                            }
                            for ($i = 0; $i < 7; $i++) {
                                echo '<div class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">';
                                echo '<span>' . round($city_data->daily->temperature_2m_max[$i]) . '°</span>';
                                echo '</div>';
                            }
                        echo "</div>";
                        echo "<div class='city-weather-forecast-bottom'>";
                            echo "<img src='" . get_template_directory_uri() . "/assets/icons/hearth-green.svg'>";
                            for ($i = 0; $i < 7; $i++) {
                                echo '<div class="weather-data-'.$i + 1 .'" style="'. ($i !== 0 ? 'display: none;' : '') .'">';
                                echo '<span>' . round($city_data->daily->uv_index_max[$i]) . '</span>';
                                echo '</div>';
                            }
                        echo "</div>";
                    echo '</div>';


                }
            }
            ?>
            <div class="weather-selected-map">
                <img src="<?php echo get_template_directory_uri()?>/assets/icons/czech-map.svg">
            </div>
        </div>
        </div>

    </div>
</div>
<?php get_footer();