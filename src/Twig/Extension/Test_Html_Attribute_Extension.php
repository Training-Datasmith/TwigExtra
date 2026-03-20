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

use Twig\Extension\Abstract_Extension;
use Twig\Twig_Function;
final class Test_Html_Attribute_Extension extends Abstract_Extension
{
    public function __construct(private readonly string $environment, private readonly bool $is_debug_enabled)
    {
    }
    /** @return TwigFunction[] */
    public function get_functions(): array
    {
        return [new Twig_Function('sylius_test_html_attribute', function (string $name, ?string $value = null): string {
            if (str_starts_with($this->environment, 'test') || $this->is_debug_enabled) {
                return sprintf('data-test-%s="%s"', $name, (string) $value);
            }
            return '';
        }, ['is_safe' => ['html']])];
    }
}