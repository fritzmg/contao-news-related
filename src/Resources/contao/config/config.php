<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
 */

/**
 * Hooks.
 */
if (isset($GLOBALS['TL_HOOKS']['newsListFetchItems'])) {
    array_unshift($GLOBALS['TL_HOOKS']['newsListFetchItems'], ['ContaoNewsRelatedBundle\Models\NewsRelatedModel', 'newsListFetchItems']);
} else {
    $GLOBALS['TL_HOOKS']['newsListFetchItems'] = [['ContaoNewsRelatedBundle\Models\NewsRelatedModel', 'newsListFetchItems']];
}
