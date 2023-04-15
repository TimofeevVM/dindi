<?php

namespace Shared\Infrastructure\Hydrator;

use BackedEnum;
use Laminas\Hydrator\AbstractHydrator;

final class TypedReflectionHydrator extends AbstractHydrator
{
    public function extract(object $object): array
    {
        throw new \Exception('TypedReflectionHydrator::extract not implement');
    }

    public function hydrate(array $data, object $object)
    {
        $reflProperties = $this->getProperties($object);
        foreach ($data as $key => $value) {
            $name = $this->hydrateName($key, $data);
            if (isset($reflProperties[$name])) {
                $value = $this->hydrateTypedValue($reflProperties[$name], $value, $data);
                $reflProperties[$name]->setValue($object, $value);
            }
        }
        return $object;
    }

    private function hydrateTypedValue(\ReflectionProperty $property, mixed $value, ?array $data = null): mixed
    {
        $value = parent::hydrateValue($property->getName(), $value, $data);

        if ($value === null && $property->getType()->allowsNull()) {
            return null;
        }

        if ($value instanceof BackedEnum) {
            return $value;
        }

        return $this->handleTypeConversions($value, $property->getType());
    }

    /**
     * @param string|object $classOrObject
     * @return list<\ReflectionProperty>
     * @throws \ReflectionException
     */
    private function getProperties(string|object $classOrObject): array
    {
        if (is_object($classOrObject)) {
            $class = $classOrObject::class;
        }

        $reflClass = new \ReflectionClass($class);
        $reflProperties = $reflClass->getProperties();

        $properties = [];
        foreach ($reflProperties as $property) {
            $properties[$property->getName()] = $property;
        }

        return $properties;
    }

    private function handleTypeConversions(mixed $value, \ReflectionType $type)
    {
        if ($value === null) {
            return null;
        }

        $name = null;
        if ($type instanceof \ReflectionNamedType) {
            $name = $type->getName();
        } else {
            $name = (string) $type;
        }

        switch ($name) {
            case 'boolean':
                $value = (bool) $value;
                break;
            case 'string':
                $value = (string) $value;
                break;
            case 'int':
                $value = (int) $value;
                break;
            case 'float':
                $value = (float) $value;
                break;
            case 'DateTime':
                if ($value === '') {
                    return null;
                }

                return new \DateTime($value);

            default:
                break;
        }

        return $value;
    }
}
