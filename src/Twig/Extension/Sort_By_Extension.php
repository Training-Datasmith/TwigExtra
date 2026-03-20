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

use Symfony\Component\Property_Access\Exception\No_Such_Property_Exception;
use Symfony\Component\Property_Access\Property_Access;
use Twig\Extension\Abstract_Extension;
use Twig\Twig_Filter;
class Sort_By_Extension extends Abstract_Extension
{
    public function get_filters(): array
    {
        return [new Twig_Filter('sylius_sort_by', $this->sort_by(...))];
    }
    /**
     * @param iterable<array<array-key, mixed>|object> $iterable
     *
     * @return array<array<array-key, mixed>|object>
     *
     * @throws NoSuchPropertyException
     */
    public function sort_by(iterable $iterable, string $field, string $order = 'ASC'): array
    {
        $array = $this->transform_iterable_to_array($iterable);
        usort($array, function (array|object $first_element, array|object $second_element) use ($field, $order): int {
            $accessor = Property_Access::create_property_accessor();
            $first_property = (string) $accessor->get_value($first_element, $field);
            $second_property = (string) $accessor->get_value($second_element, $field);
            $result = strnatcasecmp($first_property, $second_property);
            if ('DESC' === $order) {
                $result *= -1;
            }
            return $result;
        });
        return $array;
    }
    /**
     * @param iterable<array<array-key, mixed>|object> $iterable
     *
     * @return array<array<array-key, mixed>|object>
     */
    private function transform_iterable_to_array(iterable $iterable): array
    {
        if (is_array($iterable)) {
            return $iterable;
        }
        return iterator_to_array($iterable);
    }
}