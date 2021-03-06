<?php


namespace Ling\Light\Helper;


use Ling\BabyYaml\BabyYamlUtil;
use Ling\Bat\ArrayTool;
use Ling\Bat\FileSystemTool;
use Ling\DirScanner\YorgDirScannerTool;
use Ling\Light\Exception\LightException;
use Ling\Light\ServiceContainer\LightRedServiceContainer;
use Ling\Light\ServiceContainer\LightServiceContainerInterface;
use Ling\Octopus\ServiceContainer\BlueOctopusServiceContainer;
use Ling\Octopus\ServiceContainerBuilder\DarkBlueOctopusServiceContainerBuilder;

/**
 * The ServiceContainerHelper class.
 */
class ServiceContainerHelper
{


    /**
     * Returns an instance of a service container according to the given options.
     *
     * The options is an array with the following structure:
     *
     * - type: string. Defines the type of service container to return.
     *      - red: will return a RedOctopusServiceContainer
     *      - blue: (default value) will return a BlueOctopusServiceContainer.
     * - blueMode: string. Defines how the blue service container is re-created  (only applies if type=blue).
     *      - create: will re-create the service container every time
     *      - frozen: (default value) will never re-create the service container once it exists
     *      - auto: if the environment is dev: will recreate the service container only if the service configuration has changed.
     *
     *
     *
     * @param string $appDir
     * @param array $options
     * @return LightServiceContainerInterface
     * @throws LightException
     */
    public static function getInstance(string $appDir, array $options = []): LightServiceContainerInterface
    {

//        $conf = self::getServicesConf($appDir);
//        az($conf);

        $type = $options['type'] ?? 'blue';
        $blueMode = $options['blueMode'] ?? 'frozen';
        $environment = $options['environment'] ?? null;

        if ('blue' === $type) {

            // if the blue container doesn't exist yet create it.
            $path = self::getDarkBlueContainerPath($appDir);
            if (false === is_file($path) || 'create' === $blueMode) {
                $conf = self::getServicesConf($appDir, [
                    'environment' => $environment,
                ]);


                self::buildDarkBlueContainer($appDir, $conf);
                if ('auto' === $blueMode) {
                    self::createHashMap($appDir, $appDir . "/cache/LightServiceContainer.map.txt");
                }
            }

            if ('frozen' === $blueMode) {
                return self::getDarkBlueInstance($appDir);
            } elseif ('create' === $blueMode) {
                return self::getDarkBlueInstance($appDir);
            } elseif ('auto' === $blueMode) {
                /**
                 * here we compare two hash maps: the old map is located in $appDir/cache/LightServiceContainer.map.txt.
                 * The new one is temporary and created in $appDir/cache/LightServiceContainer.map-tmp.txt.
                 *
                 */
                $tmpMap = $appDir . "/cache/LightServiceContainer.map-tmp.txt";
                self::createHashMap($appDir, $tmpMap);
                $map = $appDir . "/cache/LightServiceContainer.map.txt";
                if (hash_file("haval160,4", $map) !== hash_file("haval160,4", $tmpMap)) {
                    $conf = self::getServicesConf($appDir, [
                        'environment' => $environment,
                    ]);
                    self::buildDarkBlueContainer($appDir, $conf);
                    FileSystemTool::copyFile($tmpMap, $map);
                }

                return self::getDarkBlueInstance($appDir);
            } else {
                throw new LightException("Unknown blueMode option: $blueMode");
            }


        } elseif ('red' === $type) {
            $conf = self::getServicesConf($appDir, [
                'environment' => $environment,
            ]);
            $sc = new LightRedServiceContainer();
            $sc->setApplicationDir($appDir);
            $sc->build($conf);
            return $sc;
        } else {
            throw new LightException("Unknown type option: $type");
        }
    }


    //--------------------------------------------
    //
    //--------------------------------------------
    /**
     * Returns the service configuration array based on files in $appDir/config/services.
     *
     * Available options are:
     * - environment: string=null, the name of the environment to use
     *
     *
     *
     *
     * @param string $appDir
     * @param array $options
     * @return array
     * @throws \Exception
     */
    private static function getServicesConf(string $appDir, array $options = [])
    {

        $environment = $options['environment'] ?? null;

        $servicesConf = [];
        $servicesConfDir = $appDir . "/config/services";
        if (is_dir($servicesConfDir)) {

            $preLazyVars = [];
            if (null !== $environment) {

                $envDir = $servicesConfDir . "/" . $environment;
                if (is_dir($envDir)) {
                    $files = YorgDirScannerTool::getFilesWithExtension($envDir, "byml", false, false, false);
                    $preLazyVars = [];

                    foreach ($files as $file) {
                        $fileConf = BabyYamlUtil::readFile($file);
                        foreach ($fileConf as $key => $value) {
                            $preLazyVars[] = [$key, $value, $file];

                        }
                    }

                }
            }


            $servicesConf = ConfigurationHelper::getCombinedConf($servicesConfDir, [
                "app_dir" => realpath($appDir),
            ], [
                "preLazyVars" => $preLazyVars,
            ]);
        }
        return $servicesConf;
    }


    /**
     * Builds the dark blue service container.
     *
     * @param string $appDir
     * @param array $conf
     */
    private static function buildDarkBlueContainer(string $appDir, array $conf)
    {
        $file = self::getDarkBlueContainerPath($appDir);
        $o = new DarkBlueOctopusServiceContainerBuilder();
        $o->setSicConfig($conf);
        $o->build($file, [
            'signature' => 'class LightServiceContainer extends LightBlueServiceContainer',
            'useStatements' => [
                "Ling\Light\ServiceContainer\LightBlueServiceContainer",
            ],
        ]);
    }


    /**
     * Returns the path to the dark blue service container.
     *
     * @param string $appDir
     * @return string
     */
    private static function getDarkBlueContainerPath(string $appDir)
    {
        return $appDir . "/cache/LightServiceContainer.php";
    }


    /**
     * Returns the blue octopus service container instance, found in $appDir/cache/LightServiceContainer.php
     *
     * @param string $appDir
     * @return BlueOctopusServiceContainer
     */
    private static function getDarkBlueInstance(string $appDir): BlueOctopusServiceContainer
    {
        $file = self::getDarkBlueContainerPath($appDir);
        require_once $file;
        $o = new \LightServiceContainer();
        $o->setApplicationDir($appDir);
        return $o;
    }


    /**
     * Creates a hash map for the given services configuration files (in $appDir/config/services).
     *
     * @param string $appDir
     * @param string $dstFile
     */
    private static function createHashMap(string $appDir, string $dstFile)
    {
        $servicesConfDir = $appDir . "/config/services";
        $s = "";
        if (is_dir($servicesConfDir)) {
            $files = YorgDirScannerTool::getFilesWithExtension($servicesConfDir, "byml", false, true, true);
            foreach ($files as $rpath) {
                $file = $servicesConfDir . "/" . $rpath;
                $s .= $rpath . '::' . hash_file("haval160,4", $file) . PHP_EOL;
            }
        }
        FileSystemTool::mkfile($dstFile, $s);
    }
}