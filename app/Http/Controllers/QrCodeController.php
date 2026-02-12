<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Memorial;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrGenerator;

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

        // Generate QR code SVG
        $qrSvg = QrGenerator::size(300)
            ->backgroundColor(10, 10, 15)
            ->color(201, 168, 76)
            ->margin(2)
            ->generate($qrCode->url());

        return view('dashboard.memorials.qr', compact('memorial', 'qrCode', 'qrSvg'));
    }

    public function download(Request $request, Memorial $memorial): Response
    {
        $this->authorize('update', $memorial);

        $qrCode = $memorial->qrCode;
        if (!$qrCode) {
            abort(404);
        }

        $qrPng = QrGenerator::format('png')
            ->size(600)
            ->margin(2)
            ->generate($qrCode->url());

        $qrCode->update(['downloaded_at' => now()]);

        return response($qrPng)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="gravespace-qr-' . $memorial->slug . '.png"');
    }

    public function redirect(string $code): \Illuminate\Http\RedirectResponse
    {
        $qrCode = QrCode::where('code', $code)->firstOrFail();
        return redirect()->route('memorial.show', $qrCode->memorial->slug);
    }
}
