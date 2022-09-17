<?php

namespace WebmanTech\Polyfill\Traits;

trait LaravelComponentGetter
{
    private $_laravelComponents = [];

    /**
     * @param string $configKey
     * @param string $componentClass
     * @return mixed
     */
    private function getLaravelComponent(string $configKey, string $componentClass)
    {
        if (!isset($this->_laravelComponents[$configKey])) {
            $component = config("plugin.webman-tech.polyfill.app.laravel.{$configKey}");
            if ($component instanceof \Closure) {
                $component = call_user_func($component);
            }
            if (!$component instanceof $componentClass) {
                throw new \InvalidArgumentException("{$configKey} must be an instance of {$componentClass}");
            }
            $this->_laravelComponents[$configKey] = $component;
        }

        return $this->_laravelComponents[$configKey];
    }
}