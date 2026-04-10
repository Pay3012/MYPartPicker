<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Storage extends Part
{
    use HasParent;

    // capacity_gb, type (SSD/HDD/NVMe), interface (e.g. M.2 PCIe 4.0), read_mbps, cache (true/false for ssds)
    const SPEC_FIELDS = ['capacity_gb', 'type', 'interface', 'read_mbps', 'write_mbps', 'cache'];
}
