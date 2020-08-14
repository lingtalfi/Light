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
     *
     *
     * Available options are:
     * - onCallBefore: a callable to execute just before the actual method is executed.
     *      The callable has the following signature:
     *      - fn ( type, classOrService, method, args ): void
     *
     *      With:
     *      - type: string, the type of call being executed, can be one of:
     *          - static, for static calls
     *          - instance, for calls on a new class instance
     *          - service, for service calls
     *      - classOrService: string, the name of the class or service being called
     *      - method: string, the name of the method being called
     *      - args: array, the array of arguments passed to the called method
     *
     *
     *
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

        $onCallBefore = $options['onCallBefore'] ?? null;
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

            $ret = null;
            if ('::' === $sep) {
                if (null === $service) {
//                $ret = $class::$method($args);
                    if (is_callable($onCallBefore)) {
                        $onCallBefore('static', $class, $method, $args);
                    }
                    $ret = call_user_func_array([$class, $method], $args);
                } else {
                    if (is_callable($onCallBefore)) {
                        $onCallBefore('service', $service, $method, $args);
                    }
                    $ret = call_user_func_array([$container->get($service), $method], $args);
                }
            } else {

                if (null === $service) {
                    $instance = new $class;
                    if (is_callable($onCallBefore)) {
                        $onCallBefore('instance', $class, $method, $args);
                    }
                } else {
                    $instance = $container->get($service);
                    if (is_callable($onCallBefore)) {
                        $onCallBefore('service', $service, $method, $args);
                    }
                }
                $ret = call_user_func_array([$instance, $method], $args);
            }
            return $ret;
        }
        throw new LightException("Unrecognized method syntax: $expr.");
    }
}