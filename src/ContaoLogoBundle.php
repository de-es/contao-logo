<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Logo extension.
 *
 * (c) [de][es] web solutions
 *
 * @license LGPL-3.0-or-later
 */

namespace DeEs\ContaoLogo;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class ContaoLogoBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');
    }
}
