<?php

use src\ShortenerURL;

require __DIR__ . '/vendor/autoload.php';

$url = 'https://.php.net/manual/en/function.get-headers.php';

try {
    $obj = new ShortenerURL(3);

    try {
        $obj->encode($url);
    } catch (\InvalidArgumentException $exception) {
        echo $exception->getMessage() . PHP_EOL;
    }

    try {
        $obj->decode('65fafd48a8');
    } catch (\InvalidArgumentException $exception) {
        echo $exception->getMessage() . PHP_EOL;
    }

} catch (\Exception $exception) {
    echo 'Error: ' . $exception->getMessage() . PHP_EOL;
}

