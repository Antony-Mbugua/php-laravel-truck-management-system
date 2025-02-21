<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class UserServicePdf
{
    // Generate a PDF for a single user
    public function generateUserPdf(User $user)
    {
        // Load the view for the user PDF
        $pdf = Pdf::loadView('pdf.user', compact('user'))
            ->setPaper('a4'); // Set the paper size

        return $pdf->download("user-{$user->first_name}.pdf"); // Download the PDF
    }

    // Generate a PDF for multiple users
    public function generateMultipleUsersPdf(Collection $users)
    {
        // Load the view for the multiple users PDF
        $pdf = Pdf::loadView('pdf.users', compact('users'))
            ->setPaper('a4', 'landscape'); // Set the paper size and orientation

        return $pdf->download('All-users-report.pdf'); // Download the PDF
    }
}