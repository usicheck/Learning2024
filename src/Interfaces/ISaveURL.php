<?php

namespace src\Interfaces;

use InvalidArgumentException;

interface ISaveURL
{
    /**
     * @param string $longUrl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function saveURL(string $longUrl):bool;
}

