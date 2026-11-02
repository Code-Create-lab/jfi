<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Models\InternationalPlayer;
use App\Models\Player;
use App\Models\StateAssociation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerController extends Controller
{
    /**
     * The public Player Database: approved players only, and only their
     * name, Player ID and state association (CLAUDE.md section 14, Privacy).
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $associationId = $request->integer('association');

        return view('frontend.players.index', [
            'players' => Player::query()
                ->select(['id', 'registration_no', 'name', 'state_association_id'])
                ->where('status', RegistrationStatus::Approved)
                ->when($search !== '', fn (Builder $query) => $query->where(fn (Builder $query) => $query
                    ->where('name', 'like', '%'.$search.'%')
                    ->orWhere('registration_no', 'like', '%'.$search.'%')))
                ->when($associationId > 0, fn (Builder $query) => $query->where('state_association_id', $associationId))
                ->with('stateAssociation:id,name')
                ->orderBy('name')
                ->orderBy('id')
                ->paginate(25)
                ->withQueryString(),
            'associations' => StateAssociation::query()->approved()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function international(): View
    {
        return view('frontend.players.international', [
            'internationalPlayers' => InternationalPlayer::query()
                ->published()
                ->orderBy('country')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
