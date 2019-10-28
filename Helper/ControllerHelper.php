<?php


namespace Ling\Light\Helper;


use Ling\Light\Controller\RouteAwareControllerInterface;
use Ling\Light\Core\Light;
use Ling\Light\Core\LightAwareInterface;
use Ling\Light\Exception\LightException;
use Ling\Light\Http\HttpRequestInterface;
use Ling\Light\ServiceContainer\LightServiceContainerInterface;

/**
 * The ControllerHelper class.
 */
class ControllerHelper
{


    /**
     * Returns a callable controller from the given controller, or null if no callable
     * controller can be extracted out of the given value.
     *
     * Note: This is the method used by the Core/Light instance to create its controllers,
     * and so it contains all the string transformation logic used by the Core/Light.
     * This method has been externalized so that other plugins can execute controllers
     * the same way the Core/Light instance does.
     *
     *
     *
     * @param $controller
     * @param Light $light
     * @param array $route
     * The matching route.
     * @return callable|null
     */
    public static function resolveController($controller, Light $light, array $route): ?callable
    {

        //--------------------------------------------
        // NOW RESOLVING THE CONTROLLER
        //--------------------------------------------
        $instance = null;

        // if not a callable yet, we want to turn it into a callable
        if (false === is_callable($controller)) {
            if (is_string($controller)) {
                /**
                 * We want to allow the following notations:
                 *
                 * - for non static method: MyVendor\Controller\MyController->myMethod
                 *
                 *
                 */
                $p = explode('->', $controller);
                if (2 === count($p)) {
                    $class = $p[0];
                    $method = $p[1];
                    $instance = new $class;
                    $controller = [$instance, $method];
                }

            }
        }


        //--------------------------------------------
        // INJECT THINGS IN THE CONTROLLERS
        //--------------------------------------------
        if (null !== $instance) {
            if ($instance instanceof LightAwareInterface) {
                $instance->setLight($light);
            }

            if ($instance instanceof RouteAwareControllerInterface) {
                $instance->setRoute($route);
            }
        }

        return $controller;
    }


    /**
     * Returns the controller arguments for the given controller and matching route.
     *
     *
     * Basically, the arguments are the variables defined in the route.vars,
     * or if not found, the default value of the argument if any.
     *
     * The special hint types for the Light instance and the HttpRequestInterface can be used
     * as an alternative to inject the light instance and the http request instance respectively.
     *
     *
     *
     * Note: this is the method used by the Core/Light instance to prepare arguments for a given controller.
     * It has been externalized so that other plugins can call their controllers the same way the Core/Light instance
     * does (for app consistency sake).
     *
     *
     *
     * @param callable $controller
     * @param array $route
     * @param HttpRequestInterface $httpRequest
     * @param Light $light
     * @param LightServiceContainerInterface $container
     * @return array
     * @throws LightException
     * @throws \ReflectionException
     */
    public static function getControllerArgs(callable $controller, array $route, HttpRequestInterface $httpRequest, Light $light, LightServiceContainerInterface $container)
    {
        $controllerArgs = [];
        $routeUrlParams = $route['url_params'];
        $requestArgs = $httpRequest->getGet();
        $controllerArgsInfo = ControllerHelper::getControllerArgsInfo($controller);
        foreach ($controllerArgsInfo as $argName => $info) {


            list($hasDefaultValue, $defaultValue, $hintType) = $info;
            if (array_key_exists($argName, $routeUrlParams)) {
                $controllerArgs[] = $routeUrlParams[$argName];
            } elseif (array_key_exists($argName, $requestArgs)) {
                $controllerArgs[] = $requestArgs[$argName];
            } elseif (true === $hasDefaultValue) {
                $controllerArgs[] = $defaultValue;
            } else {

                /**
                 * Special types
                 * ----------
                 * The following types can be injected directly by the light instance, without consulting the route system.
                 * The user injects them by prefixing the right hint type to its argument
                 *
                 * - Ling\Light\Core\Light
                 * - Ling\Light\Http\HttpRequestInterface
                 * - Ling\Light\ServiceContainer\LightServiceContainerInterface
                 *
                 *
                 *
                 */
                $specialTypes = [
                    "Ling\Light\Core\Light",
                    "Ling\Light\Http\HttpRequestInterface",
                    "Ling\Light\ServiceContainer\LightServiceContainerInterface",
                ];
                if (in_array($hintType, $specialTypes, true)) {
                    if ("Ling\Light\Core\Light" === $hintType) {
                        $controllerArgs[] = $light;
                    } elseif ("Ling\Light\Http\HttpRequestInterface" === $hintType) {
                        $controllerArgs[] = $httpRequest;
                    } elseif ("Ling\Light\ServiceContainer\LightServiceContainerInterface" === $hintType) {
                        $controllerArgs[] = $container;
                    }
                } else {

                    if ('_route' === $argName) {
                        $controllerArgs[] = $route;
                    } else {
                        $routeName = $route['name'];
                        throw new LightException("The controller for route $routeName defined a mandatory argument $argName, but no value was provided by the route for this argument.");
                    }
                }
            }


        }
        return $controllerArgs;
    }

    /**
     * Returns an array of controller args corresponding to the given controller.
     *
     * The controller args is an array of parameterName => item,
     * each item having the following structure:
     *      - 0: hasDefaultValue, bool. Whether the argument has a default value (i.e. if there is an equal symbol in the parameter definition).
     *      - 1: defaultValue, mixed=null. If hasDefaultValue is true, the actual default value for this parameter.
     *      - 2: hint: mixed=null. The hint type if any (bool, string, int, an object, ...)
     *
     * @param callable $controller
     * @return array
     * @throws \ReflectionException
     */
    public static function getControllerArgsInfo(callable $controller)
    {

        if ($controller instanceof \Closure) {
            $r = new \ReflectionFunction($controller);
        } elseif (is_array($controller)) {
            if (is_object($controller[0])) {
                $r = new \ReflectionMethod($controller[0], $controller[1]);
            }
        }

        $ret = [];
        // function
        $params = $r->getParameters();
        foreach ($params as $param) {


            $hasDefaultValue = $param->isDefaultValueAvailable();
            $defaultValue = null;
            if (true === $hasDefaultValue) {
                $defaultValue = $param->getDefaultValue();
            }

            $type = null;
            if (true === $param->hasType()) {
                $type = $param->getType()->getName();
            }

            $ret[$param->getName()] = [
                $hasDefaultValue,
                $defaultValue,
                $type,
            ];
        }
        return $ret;
    }
}