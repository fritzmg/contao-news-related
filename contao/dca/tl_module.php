<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
 */

$GLOBALS['TL_DCA']['tl_module']['fields']['relatedOnly'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['relatedOnly'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'clr w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['disableEmpty'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['disableEmpty'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['includeCurrent'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['includeCurrent'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['news_order']['reference'] = &$GLOBALS['TL_LANG']['tl_module'];

PaletteManipulator::create()
    ->addLegend('news_related_legend', 'config_legend', PaletteManipulator::POSITION_AFTER, true)
    ->addField('relatedOnly', 'news_related_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('includeCurrent', 'news_related_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('disableEmpty', 'news_related_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('newslist', 'tl_module')
;
