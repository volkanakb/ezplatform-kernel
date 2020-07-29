<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Values\Content\Search\Facet;

use ArrayIterator;
use eZ\Publish\API\Repository\Values\Content\Search\Facet;
use IteratorAggregate;

abstract class TermFacet extends Facet implements IteratorAggregate
{
    /**
     * An array with term as key and count of matching content objects as value.
     *
     * @var \eZ\Publish\API\Repository\Values\Content\Search\Facet\TermFacetEntry[]
     */
    public $entries = [];

    public function getIterator()
    {
        return new ArrayIterator($this->entries);
    }
}
