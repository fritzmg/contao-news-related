<?php

/*
 * This file is part of the ContaoNewsRelated Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ContaoNewsRelatedBundle\Models;


/**
 * Dynamic parent class
 */
if (class_exists('\NewsCategories\NewsModel'))
{
    class ParentModel extends \NewsCategories\NewsModel {}
}
else
{
    class ParentModel extends \Contao\NewsModel {}
}


/**
 * This class essentially only provides a hook, but no additional findBy methods.
 *
 * @author Fritz Michael Gschwantner <fmg@inspiredminds.at>
 */
class NewsRelatedModel extends ParentModel
{
	/**
	 * newsListFetchItems hook
	 *
	 * @param array   $newsArchives
	 * @param boolean $blnFeatured
	 * @param integer $limit
	 * @param integer $offset
	 * @param \ModuleNewsList $objModule
	 *
	 * @return Model\Collection|NewsModel|null|boolean
	 */
	public function newsListFetchItems($newsArchives, $blnFeatured, $limit, $offset, $objModule)
	{
		// check if filter is active in module
		if (!$objModule->relatedOnly)
		{
			return false;
		}

		// check if news archives are defined
		if (!$newsArchives)
		{
			return null;
		}

		// get the table and prepare columns, values and options
		$t = \NewsModel::getTable();
		$arrColumns = array("$t.pid IN(" . implode(',', array_map('intval', $newsArchives)) . ")");
		$arrValues = array();
		$arrOptions = array();

		// get the active item
		$item = \Config::get('useAutoItem') ? \Input::get('auto_item') : !\Input::get('items');

		// check if there is an active tem
		if (!$item)
		{
			return null;
		}

		// get the news
		$objNews = \NewsModel::findByAlias($item);

		// check if news was found
		if (!$objNews)
		{
			return null;
		}

		// Get the related news
		$arrRelated = deserialize($objNews->relatedNews);

		// Check if any related news are defined
		if (!$arrRelated)
		{
			return null;
		}

		// add related news
		$arrColumns[] = "$t.id  IN(" . implode(',', array_map('intval', $arrRelated  )) . ")";

		// regular news list stuff
		if ($blnFeatured === true)
		{
			$arrColumns[] = "$t.featured='1'";
		}
		elseif ($blnFeatured === false)
		{
			$arrColumns[] = "$t.featured=''";
		}

		if (!BE_USER_LOGGED_IN || TL_MODE == 'BE')
		{
			$time = \Date::floorToMinute();
			$arrColumns[] = "($t.start='' OR $t.start<='$time') AND ($t.stop='' OR $t.stop>'" . ($time + 60) . "') AND $t.published='1'";
		}

		$arrOptions['limit']  = $limit;
		$arrOptions['offset'] = $offset;

		// support for news_sorted and news_sorting
		switch ($objModule->news_sorting)
		{
			case 'list_date_asc':
			case 'sort_date_asc':
				$arrOptions['order'] = "$t.date ASC";
				break;

			case 'list_headline_asc':
			case 'sort_headline_asc':
				$arrOptions['order'] = "$t.headline ASC";
				break;

			case 'list_headline_desc':
			case 'sort_headline_desc':
				$arrOptions['order'] = "$t.headline DESC";
				break;

			case 'list_random':
			case 'sort_random':
				$arrOptions['order'] = "RAND()";
				break;

			default:
				$arrOptions['order'] = "$t.date DESC";
		}

		// support for news_categories
		if (class_exists('\NewsCategories\NewsModel'))
		{
			$GLOBALS['NEWS_FILTER_CATEGORIES'] = $objModule->news_filterCategories ? true : false;
			$GLOBALS['NEWS_FILTER_DEFAULT']    = deserialize($objModule->news_filterDefault, true);
			$GLOBALS['NEWS_FILTER_PRESERVE']   = $objModule->news_filterPreserve;

			$arrColumns = self::filterByCategories($arrColumns);

			unset($GLOBALS['NEWS_FILTER_CATEGORIES'], $GLOBALS['NEWS_FILTER_DEFAULT'], $GLOBALS['NEWS_FILTER_PRESERVE']);
		}

		// Return result
		return self::findBy($arrColumns, $arrValues, $arrOptions);
	}
}