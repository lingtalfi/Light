<?php


namespace Ling\Light\Helper;

use Ling\BabyYaml\BabyYamlUtil;
use Ling\Light\ServiceContainer\LightServiceContainerInterface;

/**
 * The ZFileHelper class.
 */
class ZFileHelper
{

    /**
     * Returns the path of the z file.
     *
     * @param LightServiceContainerInterface $container
     * @return string
     */
    public static function getZPath(LightServiceContainerInterface $container): string
    {
        return $container->getApplicationDir() . "/config/services/_zzz.byml";
    }


    /**
     * Sets a property in the z file.
     *
     * @param LightServiceContainerInterface $container
     * @param string $key
     * @param $value
     */
    public static function setProp(LightServiceContainerInterface $container, string $key, $value)
    {
        $file = self::getZPath($container);
        BabyYamlUtil::updateProperty($file, $key, $value);
    }


}