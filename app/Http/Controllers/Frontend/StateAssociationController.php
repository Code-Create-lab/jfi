<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreStateAssociationRequest;
use App\Mail\RegistrationReceived;
use App\Models\RegistrationDocument;
use App\Models\StateAssociation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

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

    public function create(): View
    {
        return view('frontend.associations.register');
    }

    /**
     * Save an application as pending with its logo (public disk) and
     * documents (private disk), then send the confirmation email. Files are
     * removed again if the database insert fails; a mail failure is only
     * reported.
     */
    public function store(StoreStateAssociationRequest $request): RedirectResponse
    {
        $logo = $request->file('logo')?->store('association-logos', 'public');
        $documents = RegistrationDocument::storeUploads($request->file('documents'), 'registration-documents/associations');

        try {
            $association = DB::transaction(function () use ($request, $logo, $documents): StateAssociation {
                $association = StateAssociation::create([
                    ...$request->safe()->only([
                        'name', 'state', 'city', 'address', 'pincode', 'email', 'phone',
                        'president_name', 'secretary_name', 'society_registration_no',
                    ]),
                    'logo' => $logo,
                    'terms_accepted_at' => now(),
                ]);

                $association->documents()->createMany($documents);

                return $association;
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete(array_filter([$logo]));
            Storage::disk('local')->delete(array_column($documents, 'file_path'));

            throw $exception;
        }

        try {
            Mail::to($association->email)->send(new RegistrationReceived($association));
        } catch (Throwable $exception) {
            report($exception);
        }

        return redirect()
            ->route('frontend.associations.register')
            ->with('registered_association', $association->name);
    }
}
