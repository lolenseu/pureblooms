<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function index()
    {
        // Generate QR Code for Login Page ONLY
        $loginUrl = route('login');
        $qrCode = QrCode::size(350)
            ->color(244, 63, 94)        // Rose-500
            ->backgroundColor(255, 255, 255)  // White
            ->margin(10)
            ->generate($loginUrl);

        return view('qrcode.index', compact('qrCode', 'loginUrl'));
    }
}