<?php

/*
 * This file is part of the ContaoNewsRelated Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
 * Hooks
 */
if (isset($GLOBALS['TL_HOOKS']['newsListFetchItems']))
{
	array_unshift($GLOBALS['TL_HOOKS']['newsListFetchItems'], array('ContaoNewsRelatedBundle\Models\NewsRelatedModel','newsListFetchItems'));
}
else
{
	$GLOBALS['TL_HOOKS']['newsListFetchItems'] = array(array('ContaoNewsRelatedBundle\Models\NewsRelatedModel','newsListFetchItems'));
}
