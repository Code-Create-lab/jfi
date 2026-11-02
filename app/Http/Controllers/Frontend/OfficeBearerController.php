<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OfficeBearer;
use Illuminate\View\View;

class OfficeBearerController extends Controller
{
    public function national(): View
    {
        return view('frontend.office-bearers', [
            'level' => 'national',
            'bearers' => OfficeBearer::nationalForDisplay(),
        ]);
    }
}
