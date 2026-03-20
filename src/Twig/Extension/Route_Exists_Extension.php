<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace Sylius\Twig_Extra\Twig\Extension;

use Symfony\Component\Routing\Exception\Missing_Mandatory_Parameters_Exception;
use Symfony\Component\Routing\Exception\Route_Not_Found_Exception;
use Symfony\Component\Routing\Router_Interface;
use Twig\Extension\Abstract_Extension;
use Twig\Twig_Function;
final class Route_Exists_Extension extends Abstract_Extension
{
    public function __construct(private readonly Router_Interface $router)
    {
    }
    public function get_functions(): array
    {
        return [new Twig_Function('sylius_route_exists', $this->route_exists(...))];
    }
    public function route_exists(string $route_name): bool
    {
        try {
            $this->router->generate($route_name);
            return true;
        } catch (Route_Not_Found_Exception) {
            return false;
        } catch (Missing_Mandatory_Parameters_Exception) {
            return true;
        }
    }
}