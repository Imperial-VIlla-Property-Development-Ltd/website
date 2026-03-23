<?php

namespace App\Http\Controllers;



use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;
use App\Models\Report;



class PdfController extends Controller
{
    public function registrationProof($id)
    {
        $client = Client::with('user')->findOrFail($id);
        $user = $client->user;

        // Determine payment status
        $paymentStatus = $client->payment_status ?? 'Pending';
        $isPaid = strtolower($paymentStatus) === 'paid';

        // ✅ Generate QR code using BaconQrCode manually (no imagick)
        $verificationUrl = url('/verify/' . urlencode($client->registration_id));


        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd() // use SVG backend, 100% works in DomPDF
        );
        $writer = new Writer($renderer);
        $qrSvg = $writer->writeString($verificationUrl);

        // Base64 encode for embedding
        $qrCodeSrc = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        // Generate PDF
        $pdf = Pdf::loadView('pdf.registration-proof', [
            'client' => $client,
            'user' => $user,
            'isPaid' => $isPaid,
            'qrCodeSrc' => $qrCodeSrc,
        ]);

        return $pdf->stream('registration-proof.pdf');
    }


    public function staffReport($id)
    {
        $report = Report::findOrFail($id);
        $pdf = Pdf::loadView('pdf.staff_report', compact('report'));
        return $pdf->download('report_'.$report->id.'.pdf');
    }

  


}
