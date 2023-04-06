<?php

declare(strict_types=1);

/*
 * This file is part of the Contao News Related extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoNewsRelated;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoNewsRelatedBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
