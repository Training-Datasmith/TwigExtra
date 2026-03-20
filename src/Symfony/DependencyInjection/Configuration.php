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

use Symfony\Component\Config\Definition\Builder\Array_Node_Definition;
use Symfony\Component\Config\Definition\Builder\Tree_Builder;
use Symfony\Component\Config\Definition\Configuration_Interface;
final class Configuration implements Configuration_Interface
{
    public function get_config_tree_builder(): Tree_Builder
    {
        $tree_builder = new Tree_Builder('sylius_twig_extra');
        $root_node = $tree_builder->get_root_node();
        $this->add_twig_ux_configuration($root_node);
        return $tree_builder;
    }
    private function add_twig_ux_configuration(Array_Node_Definition $root_node): void
    {
        $root_node->children()->array_node('twig_ux')->children()->array_node('anonymous_component_template_prefixes')->use_attribute_as_key('prefix_name')->validate()->always(static function ($values): array {
            foreach ($values as $path) {
                if (!is_string($path)) {
                    throw new \InvalidArgumentException(sprintf('Path must be a string. "%s" given.', get_debug_type($path)));
                }
            }
            return $values;
        })->end()->scalar_prototype()->end()->end()->end()->end()->end();
    }
}