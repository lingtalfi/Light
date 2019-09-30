<?php


namespace Ling\Light\Tool;

/**
 * The LightTool class.
 */
class LightTool
{

    /**
     * Returns whether the matching route (if any) is an ajax route.
     *
     * @return bool
     */
    public static function isAjax(): bool
    {
        return ('/index.php' !== $_SERVER["SCRIPT_NAME"]);
    }

    /**
     * Returns the plugin name from the given instance.
     *
     *
     * @param $instance
     * @return string
     */
    public static function getPluginName($instance): string
    {
        // light is part of the universe framework, so we know the naming convention.
        $p = explode('\\', get_class($instance));
        array_shift($p); // drop galaxy
        return array_shift($p); // return planet name
    }
}