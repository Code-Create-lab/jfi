<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OfficeBearer;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Sections not passed here still use the design preview data.
     */
    public function __invoke(): View
    {
        return view('frontend.home', [
            'nationalBearers' => OfficeBearer::nationalForDisplay(),
        ]);
    }
}
