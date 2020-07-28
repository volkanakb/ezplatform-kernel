<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\API\Repository\Values\Content\Search\Facet;

/**
 * Holds counts of content/location with content type.
 */
class ContentTypeFacet extends TermFacet
{
    /**
     * An array with contentTypeId as key and count of matching content objects as value.
     *
     * @var int[]
     */
    public $entries = [];
}
