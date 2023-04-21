<?php

namespace Shared\Infrastructure\PhpDI;

use DI\Container;
use DI\ContainerBuilder;
use DI\Definition\Source\DefinitionSource;

final class PhpDIFactory
{
    /**
     * @throws \Exception
     */
    public function create(string|array|DefinitionSource $definitions): Container
    {
        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->useAttributes(false);

        $builder->addDefinitions($definitions);

        return $builder->build();
    }
}
