<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\PDF;
use App\Models\Truck;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class TruckServicePdf
{
    public function generateTruckPdf(Truck $truck)
    {
        $pdf = Pdf::loadView('pdf.truck', compact('truck'))
            ->setPaper('a4');

        return $pdf->download("truck-{$truck->license_plate}.pdf");
    }

    public function generateMultipleTrucksPdf(Collection $trucks)
    {
        $pdf = Pdf::loadView('pdf.trucks', compact('trucks'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('All-trucks-report.pdf');
    }
}