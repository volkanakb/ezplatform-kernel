<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\FieldType\Country;

final class Facet
{
    public const IDC = 'ids';
    public const NAME = 'name';
    public const ALPHA2 = 'alpha2';
    public const ALPHA3 = 'alpha3';

    private function __construct()
    {
        /** This class shouldn't be instanced */
    }
}
