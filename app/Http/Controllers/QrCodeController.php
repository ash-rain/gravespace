<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Memorial;
use App\Models\QrCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QrCodeController extends Controller
{
    public function show(Request $request, Memorial $memorial): View
    {
        $this->authorize('update', $memorial);

        $qrCode = $memorial->qrCode ?? QrCode::create([
            'memorial_id' => $memorial->id,
            'code' => QrCode::generateCode(),
            'generated_at' => now(),
        ]);

        return view('dashboard.memorials.qr', compact('memorial', 'qrCode'));
    }

    public function redirect(string $code): RedirectResponse
    {
        $qrCode = QrCode::where('code', $code)->firstOrFail();
        return redirect()->route('memorial.show', $qrCode->memorial->slug);
    }
}
