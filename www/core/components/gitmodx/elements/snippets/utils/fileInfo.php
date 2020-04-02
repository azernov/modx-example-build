<?php
/**
 * Вывод информации о файле на основе шаблона $options
 *
 * @var modX $modx
 * @var string $input
 * @var string $options
 */

$options = (string) $options;
$output = '';
$data = [];
$input = $input ? MODX_BASE_PATH.$input : '';
if(file_exists($input)) {

    // Определение размера
    $count = filesize($input);
    if ($count > 1024) {
        if ($count > 1024 * 1024) {
            if ($count > 1024 * 1024 * 1024) {
                $data['filesize'] = (int)($count / (1024 * 1024 * 1024));
                $data['unit'] = 'gb';
            } else {
                $data['filesize'] = (int)($count / (1024 * 1024));
                $data['unit'] = 'mb';
            }
        } else {
            $data['filesize'] = (int)($count / 1024);
            $data['unit'] = 'kb';
        }
    } else {
        $data['filesize'] = (int)$count;
        $data['unit'] = 'b';
    }

    // Определение расширения
    $data['extension'] = pathinfo($input, PATHINFO_EXTENSION);

}

if($data) {
    if($options) {

        /** @var pdoFetch $pdoFetch */
        $pdoFetch = $modx->getService('pdoFetch', 'pdoFetch');
        $output = $pdoFetch->parseChunk($options, $data);
    } else {
        $output = json_encode($data);
    }
}

return $output;