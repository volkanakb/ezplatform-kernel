<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\Repository\Mapper;

use eZ\Publish\API\Repository\Values\Content\Search\Facet;

interface FacetDomainMapper
{
    public function supports(Facet $facet, array $languageFilter): bool;

    public function buildFacetDomainObject(Facet $facet, array $languageFilter): Facet;
}
