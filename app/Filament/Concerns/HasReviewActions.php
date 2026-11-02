<?php

namespace App\Filament\Concerns;

use App\Enums\RegistrationStatus;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationRejected;
use App\Models\Player;
use App\Models\StateAssociation;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Approve / Reject actions shared by the Players and State Associations
 * resources. The status change is saved first; the email is sent
 * synchronously and a mail failure only shows a warning.
 */
trait HasReviewActions
{
    public static function approveAction(): Action
    {
        return Action::make('approve')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->color('success')
            ->visible(fn (Player|StateAssociation $record): bool => $record->status !== RegistrationStatus::Approved)
            ->modalHeading(fn (Player|StateAssociation $record): string => 'Approve '.$record->name.'?')
            ->modalDescription(fn (Player|StateAssociation $record): string => $record instanceof Player
                ? 'The player is emailed that the registration is approved, with their Player ID.'
                : 'The association is emailed that it is approved and it appears in the public list of recognized associations.')
            ->schema([
                Textarea::make('remarks')
                    ->label('Note to the applicant (optional)')
                    ->rows(3)
                    ->maxLength(1000),
            ])
            ->action(function (Player|StateAssociation $record, array $data): void {
                $record->approve($data['remarks'] ?? null);

                static::sendStatusEmail($record, new RegistrationApproved($record), 'Approved');
            });
    }

    public static function rejectAction(): Action
    {
        return Action::make('reject')
            ->icon(Heroicon::OutlinedXCircle)
            ->color('danger')
            ->visible(fn (Player|StateAssociation $record): bool => $record->status !== RegistrationStatus::Rejected)
            ->modalHeading(fn (Player|StateAssociation $record): string => 'Reject '.$record->name.'?')
            ->modalDescription('The applicant is emailed the reason below.')
            ->schema([
                Textarea::make('remarks')
                    ->label('Reason')
                    ->required()
                    ->rows(3)
                    ->maxLength(1000),
            ])
            ->action(function (Player|StateAssociation $record, array $data): void {
                $record->reject($data['remarks']);

                static::sendStatusEmail($record, new RegistrationRejected($record), 'Rejected');
            });
    }

    /**
     * A mail failure (e.g. SMTP not yet configured) must not undo the status
     * change, so it is reported and shown as a warning.
     */
    private static function sendStatusEmail(Player|StateAssociation $record, Mailable $mail, string $title): void
    {
        try {
            Mail::to($record->email)->send($mail);

            Notification::make()->success()->title($title)->body('Email sent to '.$record->email.'.')->send();
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()->warning()->title($title)->body('The status was saved, but the email could not be sent. Check the mail settings.')->persistent()->send();
        }
    }
}
