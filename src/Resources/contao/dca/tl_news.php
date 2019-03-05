<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
 */

$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] .= ';{related_news_legend:hide},relatedNews';

$GLOBALS['TL_DCA']['tl_news']['fields']['relatedNews'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_news']['relatedNews'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['contao_newsrelated.listener.news', 'relatedNewsOptionsCallback'],
    'foreignKey' => 'tl_news.headline',
    'eval' => ['multiple' => true, 'chosen' => true, 'tl_style' => 'height:auto', 'tl_class' => 'clr'],
    'relation' => ['type' => 'belongsToMany', 'load' => 'lazy'],
    'sql' => 'blob NULL',
];
