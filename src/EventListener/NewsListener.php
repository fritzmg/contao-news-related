<?php

namespace ContaoNewsRelatedBundle\EventListener;

use Contao\DataContainer;
use Contao\NewsModel;

class NewsListener
{
	/**
	 * Options callback for the related news selection.
	 *
	 * @param DataContainer $dc
	 *
	 * @return array
	 */
	public function relatedNewsOptionsCallback(DataContainer $dc)
	{
		$t = NewsModel::getTable();
		$objNews = NewsModel::findAll(['order' => "$t.headline ASC"]);

		$arrOptions = [];
		foreach ($objNews as $news)
		{
			// skip self
			if ('tl_news' == $dc->table && $dc->activeRecord && isset($dc->activeRecord->id) && $dc->activeRecord->id == $news->id)
			{
				continue;
			}
			if ('tl_news' == $dc->parentTable && $dc->activeRecord->pid == $news->id)
			{
				continue;
			}

			$arrOptions[$news->getRelated('pid')->title][$news->id] = $news->headline;
		}

		ksort($arrOptions);

		return $arrOptions;
	}
}
