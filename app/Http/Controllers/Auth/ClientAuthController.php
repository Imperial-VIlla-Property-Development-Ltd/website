<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Document;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use App\Notifications\ClientRegisteredNotification;

class ClientAuthController extends Controller
{
    /**
     * Convert PFA name into clean code for Registration ID
     */
    private function formatPfaCode($pfa)
    {
        if (!$pfa) return "PFA";

        return strtoupper(
            str_replace(
                [' ', '-', 'Pensions', 'Ltd', 'Limited'],
                '',
                $pfa
            )
        );
    }

    // 🔹 Step 1: Biodata
    public function showRegistrationStep1()
    {
        if (auth()->check() && auth()->user()->role === 'client') {
            $client = auth()->user()->client;
            if ($client && $client->stage !== 'completed') {
                return $this->redirectToCurrentStage($client);
            }
        }

        return view('auth.register.step1');
    }

    public function postRegistrationStep1(Request $request)
    {
        $data = $request->validate([
            'firstname'       => 'required|string|max:255',
            'middlename'      => 'nullable|string|max:255',
            'lastname'        => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'pension_number'  => 'nullable|unique:users,pension_number',
            'address'         => 'required|string|max:255',
            'phone_number'    => 'required|string|max:20',
            'profile_photo'   => 'nullable|image|max:2048',
            'password'     => ['required', 'confirmed', Password::min(8)],
        ]);

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        if (empty($data['pension_number'])) {
            $data['pension_number'] = User::generatePensionNumber();
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'            => trim($data['firstname'].' '.($data['middlename'] ?? '').' '.$data['lastname']),
                'email'           => $data['email'],
                'password'        => Hash::make($data['password']),
                'role'            => 'client',
                'pension_number'  => $data['pension_number'],
                'profile_photo'   => $data['profile_photo'] ?? null,
            ]);

            $client = Client::create([
                'user_id'         => $user->id,
                'firstname'       => $data['firstname'],
                'middlename'      => $data['middlename'] ?? null,
                'lastname'        => $data['lastname'],
                'phone_number'    => $data['phone_number'],
                'address'         => $data['address'],
                // ❌ OLD — Random REG ID
                // 'registration_id' => 'REG' . Str::upper(Str::random(8)),
                // ✅ NEW — no reg number until upload is complete
                'registration_id' => null,
                'stage'           => 'pfa',
            ]);

            DB::commit();
            auth()->login($user);

            return redirect()->route('register.client.pfa')
                ->with('success', 'Biodata saved successfully! Proceed to select your PFA.');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Registration failed. Please try again.');
        }
    }

    // 🔹 Step 2: PFA
    public function showPfaPage()
    {
        $client = auth()->user()->client;

        if ($client->stage !== 'pfa') {
            return $this->redirectToCurrentStage($client);
        }

        $pfaList = [
            'Trustfund',
            'Stanbic IBTC',
            'Leadway',
            'AccessARM',
            'Fidelity',
            'Premium ',
            'AccessARM',
            'Norenbeger',
            'TangerineAPT',
            'NPF',
            'NLPC',
            'PAL',
            'FCMB',
            'Nupenco',
            'Crusader'
        ];

        return view('auth.client.pfa', compact('pfaList'));
    }

    public function postPfaSelection(Request $request)
    {
        $request->validate(['pfa' => 'required|string']);

        $client = auth()->user()->client;
        $client->update([
    'pfa_selected' => $request->pfa,
    'stage' => 'payment'
]);


        return redirect()->route('register.client.payment')
            ->with('success', 'PFA selected successfully! Proceed to payment.');
    }

    // 🔹 Step 3: Payment
    public function showPaymentPage()
    {
        $client = auth()->user()->client;
        if ($client->stage !== 'payment') {
            return $this->redirectToCurrentStage($client);
        }

        return view('auth.client.payment', compact('client'));
    }

    public function postPaymentSelection(Request $request)
    {
        $data = $request->validate(['payment_option' => 'required|in:pay_now,pay_later']);
        $client = auth()->user()->client;
        $client->update(['payment_option' => $data['payment_option'], 'stage' => 'undertaking']);

        return redirect()->route('register.client.undertaking')
            ->with('success', 'Payment option saved! Please complete the undertaking form.');
    }

    // 🔹 Step 4: Undertaking
    public function showUndertaking()
    {
        $client = auth()->user()->client;
        if ($client->stage !== 'undertaking') {
            return $this->redirectToCurrentStage($client);
        }

        return view('auth.client.undertaking');
    }

    public function postUndertaking(Request $request)
    {
        $request->validate(['agree' => 'required|boolean']);

        if (!$request->agree) {
            return back()->with('error', 'You must agree to proceed.');
        }

        $client = auth()->user()->client;
        $client->update(['stage' => 'upload']);

        return redirect()->route('register.client.upload')
            ->with('success', 'Undertaking agreed. Upload your forms to complete registration.');
    }

    // 🔹 Step 5: Upload
    public function showUpload()
    {
        $client = auth()->user()->client;
        if ($client->stage !== 'upload') {
            return $this->redirectToCurrentStage($client);
        }

        return view('auth.client.upload', compact('client'));
    }

public function postUpload(Request $request)
{
    $request->validate([
        'introductory_letter' => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
        'nin_slip'            => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
        'appointment_letter'  => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
        'office_id'           => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
        'birth_certificate'   => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
        'handwritten_letter'  => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
        'rsa_statement'       => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
        'bvn_proof'           => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
        'undertaking'         => 'required|file|mimes:pdf,jpg,png,jpeg|max:15360',
    ]);

    $client = auth()->user()->client;

    // List of fields and labels
    $fields = [
        'pfa_forms'           => 'Adamawa/pfa Forms',
        'introductory_letter' => 'Introductory Letter',
        'nin_slip'            => 'NIN Slip',
        'appointment_letter'  => 'Appointment Letter',
        'office_id'           => 'Office ID',
        'birth_certificate'   => 'Birth Certificate / Declaration',
        'handwritten_letter'  => 'Handwritten Letter',
        'bvn_proof'           => 'BVN Proof',
        'rsa_statement'       => 'RSA Statement',
        'undertaking'         => 'Undertaking Letter',
    ];

    // Upload + Save
    foreach ($fields as $field => $label) {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $path = $file->store("client_uploads/{$client->id}", 'public');
            $filename = $file->getClientOriginalName();

            Document::create([
                'client_id' => $client->id,
                'file_path' => $path,
                'title'     => $label,
            ]);
        }
    }

    // Notify Admins
    foreach (User::where('role', 'admin')->get() as $admin) {
        $admin->notify(new ClientRegisteredNotification($client));
    }

    // Generate Registration ID
    $pfaCode = $this->formatPfaCode($client->pfa_selected);
    $year = now()->year;
    $unique = str_pad(Client::count() + 1, 4, '0', STR_PAD_LEFT);

    // SAFE formatting (no slashes)
    $registrationId = "IMPV-$year-$pfaCode-$unique";

    // Update client stage
    $client->update([
        'stage' => 'new',
        'registration_id' => $registrationId,
    ]);

    // Email user
    $user = $client->user;

    try {
        \Mail::to($user->email)->queue(new \App\Mail\WelcomeClientMail($user, $client));
    } catch (\Throwable $e) {
        \Log::error("Welcome email failed: ".$e->getMessage());
    }

    // ⭐⭐⭐ FIXED — ALWAYS redirect away from upload page
    return redirect()
        ->route('register.client.proof')
        ->with('success', 'Registration completed successfully!');
}


    // 🔹 Step 6: Proof
    public function registrationProof()
    {
        $client = auth()->user()->client ?? null;
        if (!$client) abort(403);

        $isPaid = strtolower($client->payment_status ?? 'pending') === 'paid';
        return view('auth.client.proof', [
            'user' => $client->user,
            'client' => $client,
            'isPaid' => $isPaid,
        ]);
    }

    // 🔹 Utility: Smart redirector
    private function redirectToCurrentStage(Client $client)
    {
        return match ($client->stage) {
            'pfa'         => redirect()->route('register.client.pfa'),
            'payment'     => redirect()->route('register.client.payment'),
            'undertaking' => redirect()->route('register.client.undertaking'),
            'upload'      => redirect()->route('register.client.upload'),
            'completed'   => redirect()->route('register.client.proof'),
            default       => redirect()->route('register.client.step1'),
        };
    }
    public function downloadPfaForm($pfa)
{
    // Decode URL
    $pfa = urldecode($pfa);

    // Expected file name format
    $fileName = $pfa . '.pdf';

    // Path inside storage/app/pfa_forms/
    $filePath = storage_path("app/pfa_forms/{$fileName}");

    if (!file_exists($filePath)) {
        \Log::error("PFA form not found at: {$filePath}");
        abort(404, "The selected PFA form could not be found.");
    }

    return response()->download($filePath);
}

}
