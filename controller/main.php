<?php
require_once(__DIR__ . '/../lib/crest.php');
require_once(__DIR__ . '/function.php');

bx_session(); // запускаем сессию

$placementOption = json_decode($_REQUEST['PLACEMENT_OPTIONS'], 1); // данные об открытой в Б24 сущности

$id = $placementOption['ENTITY_VALUE_ID']; // id сущности
$crm = $placementOption['ENTITY_ID']; // тип сущности

if (!empty($id)) {
    $_SESSION['id'] = $id;
}

// если отправили форму
if (!empty($_POST['city'])) {
    $coordinate = getCoord($_POST['city']); // координаты введённого города

    if (is_array($coordinate)) {
        $rusTitle = json_decode(file_get_contents(__DIR__ . '/../data/translate.json'), true); // руссифицированные названия значений

        $weather = getWeather($coordinate['lat'], $coordinate['lon'], ['limit' => 1, 'lang' => 'ru_RU', 'hours' => false]); // погода введённого города
        $locality = $weather['geo_object']['locality']['name']; // Название введёного города из Яндекса
        $weather = $weather['fact']; // фактическое значение погоды

        if (!isset($weather['temp'])) {
            $error = 'Информация о погоде не найдена';
        } else {
            $data = rusArray(); // руссификация массива

            // записть в строку для читаемого вида в комментраии сделки
            $dataString = '';
            foreach ($data as $name => $value) {
                $dataString .= $name . ': ' . $value . "<br>";
            }

            // запись в комментарий сделки
            $up = CRest::call('crm.deal.update', [
                'id' => $_SESSION['id'],
                'fields' => [
                    'COMMENTS' => $dataString
                ]
            ]);
        }
    } else {
        $error = $coordinate;
    }
}

if ($crm == 'CRM_DEAL') {
    $city = CRest::call('crm.deal.get', ['id' => $id])['result'][CITY_FIELD]; // пользовательское поле "Город" в сделке
} else {
    $city = '';
}
