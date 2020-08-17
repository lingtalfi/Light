<?php


namespace Ling\Light\Helper;


use Ling\Bat\SmartCodeTool;
use Ling\Light\Core\Light;
use Ling\Light\Exception\LightException;
use Ling\Light\Http\HttpResponse;
use Ling\Light\ServiceContainer\LightServiceContainerInterface;

/**
 * The LightHelper class.
 */
class LightHelper
{

    /**
     * Register all the routes which patterns are given.
     *
     *
     * @param array $routePatterns
     * @param Light $light
     * @param null $controller
     * The controller to use. If null, a default controller is provided.
     */
    public static function createDummyRoutes(array $routePatterns, Light $light, $controller = null)
    {
        if (null === $controller) {
            $controller = function () {
                $response = new HttpResponse("Dummy page from <code>Ling\Light\Helper\LightHelper</code></p>");
                $response->send();
            };
            foreach ($routePatterns as $pattern) {
                $light->registerRoute($pattern, $controller);
            }
        }
    }


    /**
     * Executes a php method based on the notation described below, and returns the result.
     *
     *
     * This technique originally comes from the [ClassTool::executePhpMethod](https://github.com/lingtalfi/Bat/blob/master/ClassTool.md#executephpmethod-aka-smart-php-method-call).
     *
     * We've just added the possibility to call services by prefixing the service name with the @ symbol.
     *
     *
     * The given $expr must use the @page(light execute notation).
     *
     *
     * See the [examples here](https://github.com/lingtalfi/Bat/blob/master/ClassTool.md#executephpmethod-aka-smart-php-method-call).
     *
     * Available options are:
     * - argReplace: array=null, if set, will replace the arguments found in the given expr by some value. It's an array of argName => value.
     *
     *
     *
     *
     * @param string $expr
     * @param LightServiceContainerInterface $container
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public static function executeMethod(string $expr, LightServiceContainerInterface $container, array $options = [])
    {

        $argReplace = $options['argReplace'] ?? null;


        if (preg_match('!
        (?<class>[@a-zA-Z0-9_\\\\]*)
        (?<sep>::|->)
        (?<method>[a-zA-Z0-9_]*)
        (?<args>\(.*\))?
        !x', $expr, $match)) {


            $class = $match['class'];
            $service = null;
            if ("@" == substr($class, 0, 1)) {
                $service = substr($class, 1);
            }
            $sep = $match['sep'];
            $method = $match['method'];
            $args = [];
            if (array_key_exists('args', $match)) {
                $args = SmartCodeTool::parse("[" . substr($match['args'], 1, -1) . ']');
            }

            if (null !== $argReplace) {
                foreach ($args as $k => $v) {
                    if (array_key_exists($v, $argReplace)) {
                        $args[$k] = $argReplace[$v];
                    }
                }
            }

            $ret = null;
            if ('::' === $sep) {
                if (null === $service) {
//                $ret = $class::$method($args);
                    $ret = call_user_func_array([$class, $method], $args);
                } else {
                    $ret = call_user_func_array([$container->get($service), $method], $args);
                }
            } else {

                if (null === $service) {
                    $instance = new $class;
                    $sDebug = "class \"$class\"";
                } else {
                    $instance = $container->get($service);
                    $sDebug = "service \"$service\"";
                }
                $callable = [$instance, $method];
                if (false === is_callable($callable)) {
                    throw new LightException("Invalid callable passed, with $sDebug and method \"$method\".");
                }
                $ret = call_user_func_array($callable, $args);
            }
            return $ret;
        }
        throw new LightException("Unrecognized method syntax: $expr.");
    }
}