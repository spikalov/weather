<?php

/**
 * Получить актуальные данные о погоде
 *
 * @param float $lat Ширина в градусах
 * @param float $lon Долгота в градусах
 * @param array $params Другие параметры запроса
 * @return array
 */
function getWeather($lat, $lon, $params = [])
{
    $params['lat'] = $lat;
    $params['lon'] = $lon;

    $params = http_build_query($params);

    $opts = array(
        'http' => array(
            'method' => "GET",
            'header' => "X-Yandex-API-Key: " . YANDEX_KEY
        )
    );

    $url = YANDEX_API . "forecast?" . $params;

    $context = stream_context_create($opts);
    $contents = file_get_contents($url, false, $context);
    $clima = json_decode($contents, true);

    return $clima;
}

/**
 * Получить широту и долготу по адресу
 *
 * @param string $address Адрес
 * @return array Массив вида ['lat' => 55.06547, 'lon' => 51.253612]
 */
function getCoord($address)
{
    $ch = curl_init('https://geocode-maps.yandex.ru/1.x/?apikey=' . YANDEX_MAPS_KEY . '&format=json&geocode=' . urlencode($address));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $res = curl_exec($ch);

    curl_close($ch);

    $res = json_decode($res, true);
    $res = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];

    if (empty($res)) {
        return 'Адрес не найден';
    }

    $pointsArr = explode(' ', $res);
    $pointsArr = array(
        'lat' => $pointsArr[1],
        'lon' => $pointsArr[0]
    );

    return $pointsArr;
}

/**
 * Преобразование массива погоды в массив значений на русском
 *
 * @return array
 */
function rusArray()
{
    global $weather;
    global $rusTitle;
    $dataArray = array();
    foreach ($weather as $title => $value) {
        if ($title == 'condition') {
            $value = $rusTitle['condition'][$value];
        }
        if ($title == 'wind_dir') {
            $value = $rusTitle['wind_dir'][$value];
        }
        if (isset($rusTitle['title'][$title])) {
            $dataArray[$rusTitle['title'][$title]] = $value;
        }
    }
    return $dataArray;
}

/**
 * Запуск жизнеспособной в Б24 сессии
 *
 * @return void
 */
function bx_session()
{
    $secure = true;     // куки передаются только по https
    $httponly = true;   // JS имеет доступ к кукам
    $samesite = 'None';
    $maxlifetime = 86000;
    if (PHP_VERSION_ID < 70300) {
        session_set_cookie_params($maxlifetime, '/; samesite=' . $samesite, $_SERVER['HTTP_HOST'], $secure, $httponly);
    } else {
        session_set_cookie_params([
            'lifetime' => $maxlifetime,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
    }
    session_start();
}
