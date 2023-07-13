<?php

use App\Models\ContactGeneral;
function getStep(ContactGeneral $contactGeneral = null): int
{
    //step 1
    if ($contactGeneral == null)
        return 1;
    // dd($contactGeneral->person );
    //step 2
    if ($contactGeneral->company == null && $contactGeneral->type == 'company')
        return 2.5;
    if ($contactGeneral->person == null && $contactGeneral->type == 'person')
        return 2;
    //step 3
    if ($contactGeneral->detail == null)
        return 3;
    // finish
    return 4;
}
