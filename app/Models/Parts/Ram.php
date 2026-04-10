<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Ram extends Part
{
    use HasParent;

    // capacity_gb, speed_mhz, type (DDR4/DDR5), kit_count (e.g. 2 for 2x16GB)
    const SPEC_FIELDS = ['capacity_gb', 'speed_mhz', 'type', 'kit_count', 'cas_latency'];
}
