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
final class Test_Form_Attribute_Extension extends Abstract_Extension
{
    public function __construct(private readonly string $environment, private readonly bool $is_debug_enabled)
    {
    }
    /** @return TwigFunction[] */
    public function get_functions(): array
    {
        return [new Twig_Function('sylius_test_form_attribute', $this->get_test_form_attribute(...), ['is_safe' => ['html']]), new Twig_Function('sylius_test_form_attributes', function (array $attributes): array {
            if (!str_starts_with($this->environment, 'test') && $this->is_debug_enabled === false) {
                return [];
            }
            $result = [];
            foreach ($attributes as $name => $value) {
                $result[sprintf('data-test-%s', $name)] = (string) $value;
            }
            return ['attr' => $result];
        }, ['is_safe' => ['html']])];
    }
    /**
     * @return array{attr: non-empty-array<non-falsy-string, string>}|array{}
     */
    public function get_test_form_attribute(string $name, ?string $value = null): array
    {
        if (str_starts_with($this->environment, 'test') || $this->is_debug_enabled) {
            return ['attr' => ['data-test-' . $name => (string) $value]];
        }
        return [];
    }
}