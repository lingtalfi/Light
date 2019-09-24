<?php


namespace Ling\Light\Tool;

use Ling\Light\Router\LightRouterInterface;
use Ling\Light\ServiceContainer\LightServiceContainerInterface;

/**
 * The LightTool class.
 */
class LightTool
{

    /**
     * Returns whether the matching route (if any) is an ajax route.
     * When in doubt, false is returned.
     *
     * See more about ajax route in the @page(route page).
     *
     *
     *
     * @param LightServiceContainerInterface $container
     * @return bool
     * @throws \Exception
     */
    public static function isAjax(LightServiceContainerInterface $container): bool
    {
        if (true === $container->has('router')) {
            /**
             * @var $router LightRouterInterface
             */
            $router = $container->get('router');
            $matchingRoute = $router->getMatchingRoute();
            if (false !== $matchingRoute) {
                $isAjax = $matchingRoute['is_ajax'] ?? false;
                return $isAjax;
            }
        }
        return false;
    }

}