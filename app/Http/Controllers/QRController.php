<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
  /**
   * Generate and save a QR code as SVG in public folder
   */
  public function generate(Request $request)
  {
    $data = $request->input('data', 'https://legendbusinessnexus.com');
    $filename = $request->input('filename', 'sample_qr.svg');
    $publicPath = public_path('images/qr_codes/' . $filename);

    // Create directory if not exists
    if (!file_exists(dirname($publicPath))) {
      mkdir(dirname($publicPath), 0755, true);
    }

    // Generate PNG QR code
    $png = QrCode::format('png')->size(300)->generate($data);
    file_put_contents($publicPath, $png);

    return response()->json([
      'success' => true,
      'path' => 'images/qr_codes/' . $filename,
      'url' => asset('images/qr_codes/' . $filename),
    ]);
  }
}
