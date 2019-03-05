<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
 */

namespace ContaoNewsRelatedBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\NewsBundle\ContaoNewsBundle;
use ContaoNewsRelatedBundle\ContaoNewsRelatedBundle;

/**
 * Plugin for the Contao Manager.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoNewsRelatedBundle::class)
                ->setLoadAfter([ContaoNewsBundle::class, 'news_sorting']),
        ];
    }
}
