<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Cpu extends Part
{
    use HasParent;

    // cores, threads, base_clock_ghz, boost_clock_ghz, socket (e.g. AM5), tdp_watts
    const SPEC_FIELDS = ['core_count', 'tdp', 'socket', 'tdp_watts'];
}
