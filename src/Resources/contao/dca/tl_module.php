<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = str_replace(',perPage', ',perPage,relatedOnly,disableEmpty', $GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']);

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
