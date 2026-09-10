<?php

namespace App\Http\Controllers;

use App\Models\QuotationRequest;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'company' => 'required|string|max:255', 'contact' => 'required|string|max:255',
            'email' => 'required|email|max:255', 'phone' => 'required|string|max:40',
            'pickup' => 'required|string|max:255', 'destination' => 'required|string|max:255',
            'fleet' => 'required|string|max:255', 'weight' => 'nullable|string|max:255',
            'details' => 'nullable|string|max:5000',
        ]);
        QuotationRequest::create($data);

        return back()->with('quotation_success', 'Permintaan Anda sudah diterima. Tim kami akan menghubungi Anda.');
    }
}
