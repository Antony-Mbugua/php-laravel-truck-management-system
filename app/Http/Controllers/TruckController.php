<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Services\TruckServicePdf;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    protected $truckServicePdf;

    public function __construct(TruckServicePdf $truckServicePdf)
    {
        $this->truckServicePdf = $truckServicePdf;
    }

    // Method to download a single truck PDF
    public function downloadTruckPdf($id)
    {
        $truck = Truck::where('id', $id)->firstOrFail(); // Ensure a single instance is retrieved
    
        return $this->truckServicePdf->generateTruckPdf($truck);
    }
    
    // Method to download all trucks PDF
    public function downloadAllTrucksPdf()
    {
        // Retrieve all trucks
        $trucks = Truck::all();

        // Generate and return the PDF
        return $this->truckServicePdf->generateMultipleTrucksPdf($trucks);
    }
}