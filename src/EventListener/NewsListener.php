<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
 */

namespace ContaoNewsRelatedBundle\EventListener;

use Contao\DataContainer;
use Contao\NewsModel;

class NewsListener
{
    /**
     * Options callback for the related news selection.
     */
    public function relatedNewsOptionsCallback(DataContainer $dc): array
    {
        $t = NewsModel::getTable();
        $objNews = NewsModel::findAll(['order' => "$t.headline ASC"]);

        $arrOptions = [];
        foreach ($objNews as $news) {
            // skip self
            if ('tl_news' === $dc->table && $dc->activeRecord && isset($dc->activeRecord->id) && $dc->activeRecord->id === $news->id) {
                continue;
            }
            if ('tl_news' === $dc->parentTable && $dc->activeRecord->pid === $news->id) {
                continue;
            }

            $arrOptions[$news->getRelated('pid')->title][$news->id] = $news->headline;
        }

        ksort($arrOptions);

        return $arrOptions;
    }

    /**
     * Options callback for the news order selection.
     */
    public function newsOrderOptionsCallback(DataContainer $dc): array
    {
        if (class_exists(\NewsSorting::class)) {
            return (new \NewsSorting())->getSortingOptions($dc);
        }

        if ($dc->activeRecord && 'newsmenu' === $dc->activeRecord->type) {
            return ['order_date_asc', 'order_date_desc'];
        }

        return ['order_date_asc', 'order_date_desc', 'order_headline_asc', 'order_headline_desc', 'order_random', 'order_related'];
    }
}
