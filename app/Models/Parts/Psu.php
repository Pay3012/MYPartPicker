<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Psu extends Part
{
    use HasParent;

    // wattage, efficiency_rating (e.g. 80+ Gold), modular (true/false)
    const SPEC_FIELDS = ['wattage', 'efficiency_rating', 'modular'];
}
