<?php

declare(strict_types=1);

/*
 * This file is part of the Contao News Related extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoNewsRelated\EventListener\DataContainer;

use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Contao\System;

/**
 * @Callback(table="tl_module", target="config.onload")
 */
class NewsOrderOptionsCallback
{
    public function __invoke(DataContainer $dc): void
    {
        $callback = $GLOBALS['TL_DCA'][$dc->table]['fields']['news_order']['options_callback'] ?? static fn (): array => [];

        $GLOBALS['TL_DCA'][$dc->table]['fields']['news_order']['options_callback'] = static function () use ($callback, $dc): array {
            $defaultOptions = [];

            if (\is_callable($callback)) {
                $defaultOptions = $callback($dc);
            } elseif (\is_array($callback)) {
                $defaultOptions = System::importStatic($callback[0])->{$callback[1]}($dc);
            }

            if ($dc->activeRecord && 'newsmenu' === $dc->activeRecord->type) {
                return $defaultOptions;
            }

            return array_merge($defaultOptions, ['order_related']);
        };
    }
}
