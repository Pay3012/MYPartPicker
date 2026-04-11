<?php

namespace App\Models\Parts;

use App\Models\Part;
use Parental\HasParent;

class Motherboard extends Part
{
    use HasParent;

    // socket (e.g. AM5), form_factor (ATX/mATX), chipset (e.g. X670), ram_slots
    const SPEC_FIELDS = ['socket', 'form_factor', 'chipset', 'ram_slots', 'max_ram_gb'];
}
