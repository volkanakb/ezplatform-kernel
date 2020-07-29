<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\SPI\FieldType;

interface Aggregatable
{
    /**
     * Get name of the default field to be used for facet search.
     */
    public function getDefaultFacet(): string;

    /**
     * Get available facets for field.
     *
     * @return \eZ\Publish\SPI\FieldType\FacetSpecification[]
     */
    public function getFacetsSpecifications(): array;
}
