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
     * @throws \Exception
     */
    public static function isAjax(): bool
    {
        return ('/index.php' !== $_SERVER["SCRIPT_NAME"]);
    }

}