<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder\Location;

use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder\LocationFacetBuilder;
use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder\TermFacetBuilder;

/**
 * Build a Subtree facet.
 *
 * If provided the search service returns a LocationFacet which
 * contains the counts for all Locations below the child Locations.
 *
 * @todo: check hierarchical facets
 */
class SubtreeFacetBuilder extends TermFacetBuilder implements LocationFacetBuilder
{
    /**
     * The parent location.
     *
     * @var \eZ\Publish\API\Repository\Values\Content\Location
     */
    public $location;
}
