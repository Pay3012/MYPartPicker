<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Psu extends Part
{
    use HasParent;

    // wattage, efficiency_rating (e.g. 80+ Gold), modular (fully/semi/non), form_factor (e.g. ATX)
    const SPEC_FIELDS = ['wattage', 'form_factor', 'efficiency_rating', 'modular'];
}
