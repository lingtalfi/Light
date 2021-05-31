<?php


namespace Ling\Light\Helper;


/**
 * The LightServiceHelper class.
 */
class LightServiceHelper
{

    /**
     * Returns the status of a service for a given app and planetDotName.
     * The return is an int, it can be one of:
     * - 0: not existing (or unrecognized)
     * - 1: enabled
     * - 2: disabled
     *
     *
     * @param string $appDir
     * @param string $planetDotName
     * @return int
     */
    public static function getServiceStatusByPlanetDotName(string $appDir, string $planetDotName): int
    {
        $file = $appDir . "/config/services/$planetDotName.byml";
        if (true === file_exists($file)) {
            return 1;
        }
        $file .= ".dis";
        if (true === file_exists($file)) {
            return 2;
        }
        return 0;
    }
}