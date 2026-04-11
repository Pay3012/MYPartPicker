<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class PcCase extends Part
{
    use HasParent;

    // form_factor, side_panel (e.g. tempered glass, acrylic), volume_liters
    const SPEC_FIELDS = ['form_factor', 'side_panel', 'volume_liters'];
}
