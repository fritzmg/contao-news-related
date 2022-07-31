<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
 */

namespace ContaoNewsRelatedBundle\Models;

use Contao\Config;
use Contao\Date;
use Contao\Input;
use Contao\NewsModel;
use Contao\StringUtil;
use Contao\System;

/*
 * Dynamic parent class
 */
if (class_exists('\NewsCategories\NewsModel')) {
    class ParentModel extends \NewsCategories\NewsModel
    {
    }
} else {
    class ParentModel extends \Contao\NewsModel
    {
    }
}

/**
 * This class essentially only provides a hook, but no additional findBy methods.
 */
class NewsRelatedModel extends ParentModel
{
    /**
     * newsListFetchItems hook.
     *
     * @param array           $newsArchives
     * @param bool            $blnFeatured
     * @param int             $limit
     * @param int             $offset
     * @param \ModuleNewsList $objModule
     *
     * @return Model\Collection|NewsModel|bool|null
     */
    public function newsListFetchItems($newsArchives, $blnFeatured, $limit, $offset, $objModule)
    {
        // check if filter is active in module
        if (!$objModule->relatedOnly) {
            return false;
        }

        // check if news archives are defined
        if (!$newsArchives) {
            return null;
        }

        // define the return value for no item
        $retNoItem = $objModule->disableEmpty ? false : null;

        // get the table and prepare columns, values and options
        $t = self::getTable();
        $arrColumns = ["$t.pid IN(".implode(',', array_map('intval', $newsArchives)).')'];
        $arrValues = [];
        $arrOptions = [];

        // get the active item
        $item = Config::get('useAutoItem') ? Input::get('auto_item') : !Input::get('items');

        // check if there is an active tem
        if (!$item) {
            return $retNoItem;
        }

        // get the news
        $objNews = self::findByAlias($item);

        // check if news was found
        if (!$objNews) {
            return $retNoItem;
        }

        // Get the related news
        $arrRelated = StringUtil::deserialize($objNews->relatedNews);

        // Check if any related news are defined
        if (!$arrRelated) {
            return $retNoItem;
        }

        // Add current element
        if ($objModule->includeCurrent) {
            array_unshift($arrRelated, $objNews->id);
        }

        // add related news
        $arrColumns[] = "$t.id  IN(".implode(',', array_map('intval', $arrRelated)).')';

        // regular news list stuff
        if (true === $blnFeatured) {
            $arrColumns[] = "$t.featured='1'";
        } elseif (false === $blnFeatured) {
            $arrColumns[] = "$t.featured=''";
        }

        if (!System::getContainer()->get('contao.security.token_checker')->isPreviewMode()) {
            $time = Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'".($time + 60)."') AND $t.published='1'";
        }

        $arrOptions['limit'] = $limit;
        $arrOptions['offset'] = $offset;

        // fallback to news_sorting (used by news_sorted and news_sorting extension)
        $objModule->news_order = $objModule->news_order ?: $objModule->news_sorting;

        // support for news_sorted and news_sorting
        switch ($objModule->news_order) {
            case 'list_date_asc':
            case 'sort_date_asc':
            case 'order_date_asc':
                $arrOptions['order'] = "$t.date ASC";
                break;

            case 'list_headline_asc':
            case 'sort_headline_asc':
            case 'order_headline_asc':
                $arrOptions['order'] = "$t.headline ASC";
                break;

            case 'list_headline_desc':
            case 'sort_headline_desc':
            case 'order_headline_desc':
                $arrOptions['order'] = "$t.headline DESC";
                break;

            case 'list_random':
            case 'sort_random':
            case 'order_random':
                $arrOptions['order'] = 'RAND()';
                break;

            case 'order_related':
                $arrOptions['order'] = "FIELD($t.id,".implode(',', array_map('intval', $arrRelated)).')';
                break;

            default:
                $arrOptions['order'] = "$t.date DESC";
        }

        // support for news_categories
        if (class_exists('\NewsCategories\NewsModel')) {
            $GLOBALS['NEWS_FILTER_CATEGORIES'] = $objModule->news_filterCategories ? true : false;
            $GLOBALS['NEWS_FILTER_DEFAULT'] = StringUtil::deserialize($objModule->news_filterDefault, true);
            $GLOBALS['NEWS_FILTER_PRESERVE'] = $objModule->news_filterPreserve;

            $arrColumns = self::filterByCategories($arrColumns);

            unset($GLOBALS['NEWS_FILTER_CATEGORIES'], $GLOBALS['NEWS_FILTER_DEFAULT'], $GLOBALS['NEWS_FILTER_PRESERVE']);
        }

        // get the result
        return self::findBy($arrColumns, $arrValues, $arrOptions) ?: $retNoItem;
    }
}
