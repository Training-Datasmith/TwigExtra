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
namespace Sylius\Twig_Extra\Symfony\Dependency_Injection;

use Symfony\Component\Config\File_Locator;
use Symfony\Component\Dependency_Injection\Container_Builder;
use Symfony\Component\Dependency_Injection\Extension\Extension;
use Symfony\Component\Dependency_Injection\Loader\Php_File_Loader;
final class Sylius_Twig_Extra_Extension extends Extension
{
    public function load(array $configs, Container_Builder $container): void
    {
        $loader = new Php_File_Loader($container, new File_Locator(dirname(__DIR__, 3) . '/config'));
        $loader->load('services.php');
        $configuration = $this->get_configuration([], $container);
        $config = $this->process_configuration($configuration, $configs);
        $container->set_parameter('sylius_twig_extra.twig_ux.anonymous_component_template_prefixes', $config['twig_ux']['anonymous_component_template_prefixes'] ?? []);
    }
}