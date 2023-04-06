<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoNewsRelated bundle.
 *
 * (c) fritzmg
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
