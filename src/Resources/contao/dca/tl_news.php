<?php

/*
 * This file is part of the ContaoNewsRelated Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$GLOBALS['TL_DCA']['tl_news']['palettes']['default'].= ';{related_news_legend:hide},relatedNews';

$GLOBALS['TL_DCA']['tl_news']['fields']['relatedNews'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_news']['relatedNews'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'foreignKey'              => 'tl_news.headline',
	'eval'                    => array('multiple'=>true, 'chosen'=>true, 'tl_style'=>'height:auto', 'tl_class'=>'clr'),
	'relation'                => array('type'=>'belongsToMany', 'load'=>'lazy'),
	'sql'                     => "blob NULL"
);
