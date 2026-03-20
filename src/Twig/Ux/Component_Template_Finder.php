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
namespace Sylius\Twig_Extra\Twig\Ux;

use Symfony\UX\Twig_Component\Component_Template_Finder_Interface;
use Twig\Loader\Loader_Interface;
final class Component_Template_Finder implements Component_Template_Finder_Interface
{
    /** @param array<string, string> $anonymousComponentTemplatePrefixes */
    public function __construct(private readonly Component_Template_Finder_Interface $decorated, private readonly Loader_Interface $loader, private readonly array $anonymous_component_template_prefixes)
    {
    }
    public function find_anonymous_component_template(string $name): ?string
    {
        foreach ($this->anonymous_component_template_prefixes as $prefix_name => $prefix_template_path) {
            $prefix_name = sprintf('%s:', $prefix_name);
            if (str_starts_with($name, $prefix_name)) {
                return $this->get_template_path($name, $prefix_name, $prefix_template_path);
            }
        }
        return $this->decorated->find_anonymous_component_template($name);
    }
    private function get_template_path(string $name, string $prefix_name, string $prefix_template_path): ?string
    {
        $template_path = sprintf('%s/%s.html.twig', $prefix_template_path, $this->normalize_name($name, $prefix_name));
        if ($this->loader->exists($template_path)) {
            return $template_path;
        }
        return null;
    }
    private function normalize_name(string $name, string $prefix_name): string
    {
        return str_replace(':', '/', str_replace($prefix_name, '', $name));
    }
}