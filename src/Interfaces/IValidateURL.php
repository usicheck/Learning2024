<?php

namespace src\Interfaces;

use InvalidArgumentException;

interface IValidateURL
{
    /**
     * @param string $url
     * @return bool
     */
    public function validateURL(string $url): bool;
}

