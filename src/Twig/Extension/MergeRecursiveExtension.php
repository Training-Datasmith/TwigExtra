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
use Twig\Twig_Filter;
final class Merge_Recursive_Extension extends Abstract_Extension
{
    public function get_filters(): array
    {
        return [new Twig_Filter('sylius_merge_recursive', fn(array $first_array, array $second_array): array => $this->merge_recursive($first_array, $second_array))];
    }
    /**
     * @param mixed[] ...$arrays
     *
     * @return mixed[]
     */
    public function merge_recursive(array ...$arrays): array
    {
        return array_merge_recursive(...$arrays);
    }
}