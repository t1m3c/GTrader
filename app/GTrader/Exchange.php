<?php

Namespace GTrader;

use GTrader\Exchange;

abstract class Exchange extends Skeleton
{

    abstract public function getTicker(array $params = []);
    abstract public function getCandles(array $params = []);


    public static function getDefault(string $param)
    {
        $exchange = Exchange::singleton();
        if ('exchange' === $param)
            return $exchange->getParam('local_name');
        if ('symbol' === $param)
        {
            $symbols = $exchange->getParam('symbols');
            $first_symbol = reset($symbols);
            return $first_symbol['local_name'];
        }
        if ('resolution' === $param)
        {
            $symbols = $exchange->getParam('symbols');
            $first_symbol = reset($symbols);
            $resolutions = $first_symbol['resolutions'];
            reset($resolutions);
            return key($resolutions);
        }
        return null;
    }



    public static function getESR()
    {
        $esr = [];
        $default_exchange = Exchange::singleton();
        foreach ($default_exchange->getParam('available_exchanges') as $class)
        {
            $exchange = Exchange::make($class);
            $exo = new \stdClass();
            $exo->name = $exchange->getParam('local_name');
            $exo->long_name = $exchange->getParam('long_name');
            $exo->symbols = [];

            foreach ($exchange->getParam('symbols') as $symbol)
            {
                $symo = new \stdClass();
                $symo->name = $symbol['local_name'];
                $symo->long_name = $symbol['long_name'];
                $symo->resolutions = $symbol['resolutions'];
                $exo->symbols[] = $symo;
            }
            $esr[] = $exo;
        }
        return $esr;
    }
}











