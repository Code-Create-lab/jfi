<?php

namespace App\Models\Concerns;

use App\Enums\RegistrationStatus;

/**
 * Approve / reject for registrations (Player, StateAssociation). Status and
 * review fields are not mass assignable, so they are set here explicitly.
 */
trait Reviewable
{
    public function approve(?string $remarks = null): void
    {
        $this->review(RegistrationStatus::Approved, $remarks);
    }

    /**
     * The remarks are sent to the applicant as the reason.
     */
    public function reject(string $remarks): void
    {
        $this->review(RegistrationStatus::Rejected, $remarks);
    }

    private function review(RegistrationStatus $status, ?string $remarks): void
    {
        $this->status = $status;
        $this->admin_remarks = $remarks;
        $this->reviewed_at = now();
        $this->save();
    }
}
