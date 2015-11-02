<?php

class BetterDateTime extends DateTime
{
    public function format($format)
    {
        return parent::format($format);
    }

    public function add($interval)
    {
        return parent::add($interval);
    }
}
