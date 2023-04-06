<?php

declare(strict_types=1);

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

$GLOBALS['TL_DCA']['tl_module']['fields']['news_order']['options_callback'] = ['contao_newsrelated.listener.news', 'newsOrderOptionsCallback'];
$GLOBALS['TL_DCA']['tl_module']['fields']['news_order']['reference'] = &$GLOBALS['TL_LANG']['tl_module'];

\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('relatedOnly', 'config_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->addField('includeCurrent', 'config_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->addField('disableEmpty', 'config_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('newslist', 'tl_module')
;
