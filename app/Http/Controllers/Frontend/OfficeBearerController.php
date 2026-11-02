<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\BearerLevel;
use App\Http\Controllers\Controller;
use App\Models\OfficeBearer;
use App\Models\StateAssociation;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Published state office bearers of approved associations, grouped by
     * association in the view (ordered by association name, then sort order).
     */
    public function state(): View
    {
        return view('frontend.office-bearers', [
            'level' => 'state',
            'bearers' => OfficeBearer::query()
                ->published()
                ->where('level', BearerLevel::State)
                ->whereHas('stateAssociation', fn (Builder $query) => $query->approved())
                ->with('stateAssociation')
                ->orderBy(StateAssociation::query()->select('name')->whereColumn('state_associations.id', 'office_bearers.state_association_id'))
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }
}
