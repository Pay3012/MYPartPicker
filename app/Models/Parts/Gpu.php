<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Gpu extends Part
{
    use HasParent;

    // vram_gb, boost_clock_mhz, tdp_watts, interface (e.g. PCIe 4.0)
    const SPEC_FIELDS = ['chipset', 'vram_gb', 'length_mm'];
}
