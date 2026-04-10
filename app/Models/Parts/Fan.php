<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Fan extends Part
{
    use HasParent;

    // size_mm (e.g. 120/140), max_rpm, max_cfm, bearing_type (e.g. Fluid Dynamic)
    const SPEC_FIELDS = ['size_mm', 'max_rpm', 'max_cfm', 'bearing_type'];
}
