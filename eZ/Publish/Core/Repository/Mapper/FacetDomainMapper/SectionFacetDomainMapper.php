<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\Repository\Mapper\FacetDomainMapper;

use eZ\Publish\API\Repository\Values\Content\Search\Facet;
use eZ\Publish\Core\Repository\Mapper\FacetDomainMapper;

final class SectionFacetDomainMapper implements FacetDomainMapper
{
    /** @var \eZ\Publish\API\Repository\SectionService */
    private $sectionService;

    public function supports(Facet $facet, array $languageFilter): bool
    {
        return $facet instanceof Facet\SectionFacet;
    }

    public function buildFacetDomainObject(Facet $facet, array $languageFilter): Facet
    {
        $result = new Facet\SectionFacet();
        $result->name = $facet->name;
        foreach ($facet as $sectionId => $count) {
            $result->entries[] = $count;
        }

        return $result;
    }
}
