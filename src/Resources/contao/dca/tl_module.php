<?php

/*
 * This file is part of the ContaoNewsRelated Bundle.
 *
 * (c) Fritz Michael Gschwantner <https://github.com/fritzmg>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = str_replace(',skipFirst', ',skipFirst,relatedOnly', $GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']);

$GLOBALS['TL_DCA']['tl_module']['fields']['relatedOnly'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['relatedOnly'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'clr w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);
