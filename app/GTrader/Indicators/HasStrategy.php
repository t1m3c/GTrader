<?php

namespace GTrader\Indicators;

use Illuminate\Support\Arr;

trait HasStrategy
{
    use \GTrader\HasStrategy;

    public function getStrategyOwner()
    {
        if (!$owner = $this->getOwner()) {
            error_log($this->getShortClass().'::getStrategyOwner() could not get owner');
            return null;
        }
        return $owner;
    }

    public function getParamString(array $except_keys = [], array $overrides = [])
    {
        if (!$strategy_name = Arr::get($overrides, 'strategy_id')) {
            $strategy_name = 'Could not load strategy';
            if ($strategy = $this->getStrategy()) {
                $strategy_name = $strategy->getParam('name', 'Unknown Strategy');
            }
        }
        if (-1 == $this->getParam('indicator.strategy_id')) {
            $strategy_name = 'Auto: '.$strategy_name;
        }
        $overrides = array_replace_recursive($overrides, ['strategy_id' => $strategy_name]);
        return parent::getParamString($except_keys, $overrides);
    }
}
