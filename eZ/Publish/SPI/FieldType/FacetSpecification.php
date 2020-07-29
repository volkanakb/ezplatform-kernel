<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\SPI\FieldType;

use eZ\Publish\SPI\Persistence\ValueObject;

final class FacetSpecification extends ValueObject
{
    public const TYPE_TERM = 1;
    public const TYPE_RANGE = 2;

    /** @var string */
    private $field;

    /** @var int */
    private $type;

    public function __construct(string $field, int $type)
    {
        parent::__construct();

        $this->field = $field;
        $this->type = $type;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getType(): int
    {
        return $this->type;
    }
}
