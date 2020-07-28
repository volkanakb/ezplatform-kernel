<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Values\Content\Search\Facet;

use Iterator;

/**
 * Holds counts for content/locations in sections.
 */
final class SectionFacet extends TermFacet
{
    /**
     * An array with sectionId as key and count of matching content objects as value.
     *
     * @var int[]
     */
    public $entries = [];
}
