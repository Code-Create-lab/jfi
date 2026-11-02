<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StateAssociation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StateAssociationController extends Controller
{
    /**
     * Recognized (approved) associations, ordered by state.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $state = (string) $request->query('state');

        return view('frontend.associations.index', [
            'associations' => StateAssociation::query()
                ->approved()
                ->when($search !== '', fn (Builder $query) => $query->where('name', 'like', '%'.$search.'%'))
                ->when(in_array($state, config('jumpball.states'), true), fn (Builder $query) => $query->where('state', $state))
                ->orderBy('state')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
