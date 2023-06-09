<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrGenerate extends Controller
{
    /**
     * Генерация qr кода.
     */
    public function __invoke(Request $request)
    {
        return QrCode::size(300)->generate('http://127.0.0.1:8000/');
    }
}
