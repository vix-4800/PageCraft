<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\Expr\AppEnvironmentComparisonToParameterRector;
use RectorLaravel\Rector\FuncCall\NotFilledBlankFuncCallToBlankFilledFuncCallRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\If_\AbortIfRector;
use RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use RectorLaravel\Set\LaravelLevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/bootstrap',
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->withPhpSets()
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_110,
    ])
    ->withPreparedSets(
        codingStyle: true,
        naming: true,
        privatization: true,
        rectorPreset: true,
        strictBooleans: true,
        earlyReturn: true
    )
    ->withRules([
        EloquentOrderByToLatestOrOldestRector::class,
        AbortIfRector::class,
        RemoveDumpDataDeadCodeRector::class,
        ValidationRuleArrayStringValueToArrayRector::class,
        AppEnvironmentComparisonToParameterRector::class,
        AssertStatusToAssertMethodRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        NotFilledBlankFuncCallToBlankFilledFuncCallRector::class,
    ])
    ->withImportNames(removeUnusedImports: true)
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0)
    ->withAttributesSets();
