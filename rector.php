<?php

declare(strict_types=1);

use Contao\Rector\Set\SetList;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;

return RectorConfig::configure()
    ->withSets([SetList::CONTAO])
    ->withPaths([
        __DIR__.'/contao',
        __DIR__.'/src',
    ])
    ->withSkip([
        FirstClassCallableRector::class,
    ])
    ->withParallel()
    ->withCache(sys_get_temp_dir().'/rector_cache')
;
