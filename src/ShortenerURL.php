<?php

namespace src;


use src\Interfaces\ISaveURL;
use src\Interfaces\IUrlDecoder;
use src\Interfaces\IUrlEncoder;
use src\Interfaces\IValidateURL;

class ShortenerURL implements IUrlEncoder, IUrlDecoder, IValidateURL, ISaveURL
{
    public function __construct(public int $length = 10)
    {
    }

    public function validateURL($url): bool
    {

        if ($this->length<10) {
            throw new \InvalidArgumentException('URL length for short link must be at least 10 characters.');
        }


        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $url_p = parse_url($url);
        if (empty ($url_p ['host'])) {
            return false;
        }

        $headers = get_headers($url); //тут отримуємо заголовок відповіді на запит
        if ($headers === false) {
            return false;
        }

        $response = substr($headers[0], 9, 3); //прибираю лишнє, щоб порівняти коди відповіді
        if ($response != 200 && $response != 201 && $response != 301 && $response != 302) {
            return false;
        }


        return true;
    }

    public function saveURL(string $longUrl): bool
    {
        if (!$this->validateURL($longUrl)) {
            return false;
        }
        $storage = __DIR__ . '/../storage/';
        $idURL = uniqid();
        $shortURL = substr($idURL, 0, $this->length);
        $result = file_put_contents($storage . $shortURL, $longUrl);

        return $result !== false;
    }

    public function encode($url): string
    {

        $shortURL = $this->saveURL($url);

        if ($shortURL !== false) {
            return $shortURL;
        } else {
            throw new \InvalidArgumentException('Link is not correct or it\'s not working.');
        }
    }

    public function decode($code): string
    {
        $path = __DIR__ . '/../storage/' . $code;
        if (file_exists($path)) {
            echo file_get_contents($path) . PHP_EOL;
            return file_get_contents($path);
        } else {
            throw new \InvalidArgumentException('Wrong short link.');
        }
    }
}

