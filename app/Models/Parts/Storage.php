<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Storage extends Part
{
    use HasParent;

    // capacity_gb, drive_type (SSD/HDD/NVMe), interface (e.g. M.2 PCIe 4.0), form_factor (e.g. 2.5"/3.5"), read_mbps, write_mbps, cache (e.g. 256MB)
    const SPEC_FIELDS = ['capacity_gb', 'drive_type', 'interface', 'form_factor', 'cache'];
}
