<?php

declare(strict_types=1);

/*
 * This file is part of the Contao News Related extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoNewsRelated\EventListener;

use Contao\Input;
use Contao\NewsModel;
use Contao\StringUtil;
use InspiredMinds\ContaoNewsFilterEvent\Event\NewsFilterEvent;

class NewsFilterEventListener
{
    public function __invoke(NewsFilterEvent $event): void
    {
        $module = $event->getModule();

        if (!$module->relatedOnly) {
            return;
        }

        $archives = $event->getArchives();

        if (empty($archives)) {
            $this->forceEmptyResultIfApplicable($event);

            return;
        }

        $newsAlias = Input::get('auto_item', false, true);

        if (empty($newsAlias)) {
            $this->forceEmptyResultIfApplicable($event);

            return;
        }

        $news = NewsModel::findByAlias($newsAlias);

        if (null === $news) {
            $this->forceEmptyResultIfApplicable($event);

            return;
        }

        $related = array_map('intval', StringUtil::deserialize($news->relatedNews, true));

        if (empty($related)) {
            $this->forceEmptyResultIfApplicable($event);

            return;
        }

        // Add current element
        if ($module->includeCurrent) {
            array_unshift($related, (int) $news->id);
        }

        $event->addColumn('tl_news.id IN ('.implode(',', $related).')');

        // Set sorting
        if ('order_related' === $module->news_order) {
            $event->addOption('order', 'FIELD(tl_news.id,'.implode(',', $related).')', true);
        }
    }

    private function forceEmptyResultIfApplicable(NewsFilterEvent $event): void
    {
        if ($event->getModule()->disableEmpty) {
            return;
        }

        $event
            ->setForceEmptyResult(true)
            ->stopPropagation()
        ;
    }
}
