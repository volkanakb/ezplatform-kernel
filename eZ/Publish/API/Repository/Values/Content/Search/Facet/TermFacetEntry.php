<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Values\Content\Search\Facet;

use eZ\Publish\API\Repository\Values\ValueObject;

class TermFacetEntry extends ValueObject
{
    /** @var mixed */
    private $key;

    /** @var int */
    private $value;

    public function __construct($key, int $value)
    {
        parent::__construct();

        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
