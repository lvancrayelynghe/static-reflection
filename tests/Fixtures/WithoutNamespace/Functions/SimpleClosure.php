<?php

$varToBeUsed = 42;

$closure = function ($paramRequired, array $paramOptionnal = null) use (&$varToBeUsed) {
    static $cache;

    if (is_null($cache)) {
        $cache = $paramRequired + $varToBeUsed;
    }

    return $cache;
};
