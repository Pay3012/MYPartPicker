<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Cooler extends Part
{
    use HasParent;

    // type (Air/AIO), tdp_rating_watts, fan_size_mm, socket_support (e.g. AM5/LGA1700)
    const SPEC_FIELDS = ['cooler_type', 'tdp_rating_watts', 'aio_size'];
}
