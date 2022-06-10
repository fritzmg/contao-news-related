<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_news']['fields']['relatedNews'] = [
    'exclude' => true,
    'inputType' => 'picker',
    'eval' => ['multiple' => true, 'fieldType' => 'checkbox', 'tl_class' => 'clr'],
    'relation' => ['type' => 'belongsToMany', 'load' => 'lazy', 'table' => 'tl_news'],
    'sql' => ['type' => 'blob', 'length' => 65535, 'notnull' => false],
];

$pm = PaletteManipulator::create()
    ->addLegend('related_news_legend', null, PaletteManipulator::POSITION_AFTER, true)
    ->addField('relatedNews', 'related_news_legend', PaletteManipulator::POSITION_APPEND)
;

foreach ($GLOBALS['TL_DCA']['tl_news']['palettes'] as $name => $palette) {
    if (!\is_string($palette)) {
        continue;
    }

    $pm->applyToPalette($name, 'tl_news');
}
