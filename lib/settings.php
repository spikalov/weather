<?php
define('C_REST_CLIENT_ID', 'local.620906489481a3.61499041'); //Application ID
define('C_REST_CLIENT_SECRET', 'GMFWARsfU9WBxXBkQB7kdP60YzdsVxfMDOv0oF9d9xgmBCeINt'); //Application key
// or
define('C_REST_WEB_HOOK_URL', 'https://b24-4nr9cw.bitrix24.ru/rest/1/hkkg57ivuqfuhac2/'); //url on creat Webhook

define('C_REST_CURRENT_ENCODING', 'windows-1251');
define('C_REST_IGNORE_SSL', true); //turn off validate ssl by curl
define('C_REST_LOG_TYPE_DUMP', true); //logs save var_export for viewing convenience
define('C_REST_BLOCK_LOG', true); //turn off default logs
define('C_REST_LOGS_DIR', __DIR__ . '/logs/'); //directory path to save the log

define('YANDEX_KEY', '0455b1ab-78f7-4bf6-a9c6-5cf711e712e5'); // ключ API к Яндекс.Погода
define('YANDEX_API', 'https://api.weather.yandex.ru/v2/'); // ссылка для запросов к Яндекс.Погода
define('YANDEX_MAPS_KEY', '1a3111aa-3df8-4c69-b543-0632eedca717'); // ключ API к Яндекс.Карты (геокодер)
define('CITY_FIELD', 'UF_CRM_1644759907'); // пользовательское поле "Город" в сделке
