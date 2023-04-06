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
use InspiredMinds\ContaoNewsSorting\EventListener\ModuleDataContainerListener;

/**
 * @Callback(table="tl_module", target="fields.news_order.options", priority=100)
 */
class NewsOrderOptionsCallback
{
    private $newsSortingOptionsListener;

    public function __construct(ModuleDataContainerListener $newsSortingOptionsListener = null)
    {
        $this->newsSortingOptionsListener = $newsSortingOptionsListener;
    }

    public function __invoke(DataContainer $dc): array
    {
        $defaultOptions = (new \tl_module_news())->getSortingOptions($dc);

        if ($dc->activeRecord && 'newsmenu' === $dc->activeRecord->type) {
            return $defaultOptions;
        }

        if (null !== $this->newsSortingOptionsListener) {
            return array_merge($this->newsSortingOptionsListener->getSortingOptions($dc), ['order_related']);
        }

        return array_merge($defaultOptions, ['order_related']);
    }
}
