<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH & DASHBOARD CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ClientAuthController;
use App\Http\Controllers\Dashboard\ClientDashboardController;
use App\Http\Controllers\Dashboard\StaffDashboardController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\SuperAdminDashboardController;

use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\LocationController;

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;


/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ExceptionController as AdminExceptionController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Auth\SuperAdminLoginController;


/*
|--------------------------------------------------------------------------
| STAFF CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Staff\ReportController as StaffReportController;
use App\Http\Controllers\Staff\ClientManagementController as StaffClientController;


/*
|--------------------------------------------------------------------------
| COMMON CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\DocumentController;
use App\Http\Controllers\Auth\OtpController;


/*
|--------------------------------------------------------------------------
| SUPER ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\SuperAdmin\AdminManagementController;
use App\Http\Controllers\SuperAdmin\StaffManagementController;
use App\Http\Controllers\SuperAdmin\ClientManagementController as SuperAdminClientController;



/*
|--------------------------------------------------------------------------
| PUBLIC & AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/register/client/download/{pfa}', [ClientAuthController::class, 'downloadPfaForm'])
    ->name('register.client.download');

Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');

Route::get('/client/form/{client}', [ClientDashboardController::class, 'downloadDisbursementForm'])
    ->name('client.form.download');


// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// OTP
Route::get('/otp', [OtpController::class, 'showForm'])->name('otp.form');
Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');



/*
|--------------------------------------------------------------------------
| CLIENT REGISTRATION
|--------------------------------------------------------------------------
*/

Route::prefix('register/client')->group(function () {

    Route::get('/step1', [ClientAuthController::class, 'showRegistrationStep1'])
        ->name('register.client.step1');

    Route::post('/step1', [ClientAuthController::class, 'postRegistrationStep1'])
        ->name('register.client.step1.post');

    Route::get('/pfa', [ClientAuthController::class, 'showPfaPage'])
        ->name('register.client.pfa');

    Route::post('/pfa', [ClientAuthController::class, 'postPfaSelection'])
        ->name('register.client.pfa.post');

    Route::get('/payment', [ClientAuthController::class, 'showPaymentPage'])
        ->name('register.client.payment');

    Route::post('/payment', [ClientAuthController::class, 'postPaymentSelection'])
        ->name('register.client.payment.post');

    Route::get('/undertaking', [ClientAuthController::class, 'showUndertaking'])
        ->name('register.client.undertaking');

    Route::post('/undertaking', [ClientAuthController::class, 'postUndertaking'])
        ->name('register.client.undertaking.post');

    Route::get('/upload', [ClientAuthController::class, 'showUpload'])
        ->name('register.client.upload');

    Route::post('/upload', [ClientAuthController::class, 'postUpload'])
        ->name('register.client.upload.post');

    Route::get('/pdf/registration-proof/{id}', [PdfController::class, 'registrationProof'])
        ->middleware('auth')
        ->name('pdf.registration-proof');

    Route::middleware(['auth', 'role:client'])
        ->get('/proof', [ClientAuthController::class, 'registrationProof'])
        ->name('register.client.proof');

    Route::get('/download/{pfa}', [ClientAuthController::class, 'downloadPfaForm'])
        ->name('register.client.download');
});


// Client posts location (after login)
Route::middleware(['auth'])->group(function () {
    Route::post('/client/location', [LocationController::class, 'store'])
        ->name('client.location.store');
});



/*
|--------------------------------------------------------------------------
| CLIENT DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:client'])
    ->prefix('dashboard/client')
    ->group(function () {

        Route::get('/', [ClientDashboardController::class, 'index'])
            ->name('dashboard.client');

        // Documents
        Route::get('/documents', [DocumentController::class, 'index'])
            ->name('client.documents.index');

        Route::post('/documents', [DocumentController::class, 'store'])
            ->name('client.documents.store');

        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])
            ->name('client.documents.destroy');
    });



/*
|--------------------------------------------------------------------------
| STAFF DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:staff'])
    ->prefix('dashboard/staff')
    ->group(function () {

        Route::get('/', [StaffDashboardController::class, 'index'])
            ->name('dashboard.staff');

        // Reports
        Route::get('/reports', [StaffReportController::class, 'index'])
            ->name('staff.reports.index');

        Route::get('/reports/create', [StaffReportController::class, 'create'])
            ->name('staff.reports.create');

        Route::post('/reports', [StaffReportController::class, 'store'])
            ->name('staff.reports.store');

        // Client Management
        Route::get('/clients', [StaffClientController::class, 'index'])
            ->name('staff.clients');

        Route::post('/clients/{client}/update-stage', [StaffClientController::class, 'updateStage'])
            ->name('staff.clients.updateStage');

        Route::post('/clients/{client}/send-message', [StaffClientController::class, 'sendMessage'])
            ->name('staff.clients.sendMessage');

        Route::get('/clients/{client}/profile', [StaffClientController::class, 'profile'])
            ->name('staff.clients.profile');

        // Documents
        Route::get('/dashboard/staff/documents', [DocumentController::class, 'index'])
            ->name('staff.documents.index');

        Route::get('/dashboard/staff/documents/{document}/review', [DocumentController::class, 'review'])
            ->name('staff.documents.review');

        Route::post('/dashboard/staff/documents/{document}/update', [DocumentController::class, 'updateStatus'])
            ->name('staff.documents.update');

        // Update stage with reason
        Route::post('/clients/{client}/update-stage-with-reason',
            [StaffClientController::class, 'updateStageWithReason'])
            ->name('staff.clients.updateStageWithReason');

        // Work Session
        Route::post('/session/start', [WorkSessionController::class, 'start'])
            ->name('staff.session.start');

        Route::post('/session/end', [WorkSessionController::class, 'end'])
            ->name('staff.session.end');
    });



/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('dashboard/admin')
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard.admin');

        // Staff management
        Route::resource('staff', AdminStaffController::class, ['as' => 'admin']);
        Route::post('/staff/{staff}/toggle', [AdminStaffController::class, 'toggleActive'])
            ->name('admin.staff.toggle');

        // Client management
        Route::get('/clients', [AdminClientController::class, 'index'])
            ->name('admin.client.index');

        Route::get('/clients/create', [AdminClientController::class, 'create'])
            ->name('admin.client.create');

        Route::post('/clients', [AdminClientController::class, 'store'])
            ->name('admin.client.store');

        Route::get('/clients/{client}', [AdminClientController::class, 'show'])
            ->name('admin.client.show');

        Route::get('/clients/{client}/edit', [AdminClientController::class, 'edit'])
            ->name('admin.client.edit');

        Route::put('/clients/{client}', [AdminClientController::class, 'update'])
            ->name('admin.client.update');

        Route::delete('/clients/{client}', [AdminClientController::class, 'destroy'])
            ->name('admin.client.destroy');

        Route::post('/admin/client/update-info', [AdminClientController::class, 'updateInfo'])
            ->name('admin.client.updateInfo');

        // Bulk assign
        Route::post('/clients/bulk-assign', [AdminClientController::class, 'bulkAssign'])
            ->name('admin.client.bulkAssign');

        Route::get('/assignments', [AssignmentController::class, 'index'])
            ->name('admin.assignments.index');

        Route::post('/assignments', [AssignmentController::class, 'assign'])
            ->name('admin.assignments.assign');

        Route::post('/dashboard/admin/clients/bulk-delete', [AdminClientController::class, 'bulkDelete'])
            ->name('admin.client.bulkDelete');

        // Map
        Route::get('/admin/map', [MapController::class, 'index'])->name('admin.map');
        Route::get('/admin/map/locations', [MapController::class, 'locations'])->name('admin.map.locations');
        Route::get('/admin/map/stats', [MapController::class, 'stats'])->name('admin.map.stats');
        Route::get('/admin/map/activity', [MapController::class, 'activity'])->name('admin.map.activity');
        Route::get('/admin/map/heat', [MapController::class, 'heat'])->name('admin.map.heat');

        // Documents
        Route::get('/dashboard/admin/documents', [DocumentController::class, 'index'])
            ->name('admin.documents.index');

        Route::get('/dashboard/admin/documents/{document}/review', [DocumentController::class, 'review'])
            ->name('admin.documents.review');

        Route::post('/dashboard/admin/documents/{document}/update', [DocumentController::class, 'updateStatus'])
            ->name('admin.documents.update');

        // Update stage/account number
        Route::post('/clients/{client}/update-stage', [AdminClientController::class, 'updateStage'])
            ->name('admin.client.updateStage');

        Route::post('/clients/{client}/update-account', [AdminClientController::class, 'updateAccount'])
            ->name('admin.client.updateAccount');

        // Announcements
        Route::get('/announcements', [AdminAnnouncementController::class, 'index'])
            ->name('admin.announcements');

        Route::post('/announcements', [AdminAnnouncementController::class, 'store'])
            ->name('admin.announcements.store');

        // Exceptions
        Route::get('/exceptions', [AdminExceptionController::class, 'index'])
            ->name('admin.exceptions');

        Route::post('/exceptions', [AdminExceptionController::class, 'store'])
            ->name('admin.exceptions.store');

        // Reports
        Route::get('/reports', [AdminReportController::class, 'index'])
            ->name('admin.reports.index');

        // Activity Logs
        Route::get('/activity', [ActivityLogController::class, 'index'])
            ->name('admin.activity.index');
    });


// Admin access to client documents
Route::get('/client/{client}/documents', [AdminClientController::class, 'viewDocuments'])
    ->name('admin.client.documents')
    ->middleware(['auth', 'role:admin']);

Route::post('/admin/documents/download-selected', 
    [DocumentController::class, 'downloadSelected'])
    ->name('admin.client.downloadSelected');



// Verification route
Route::get('/verify/{registration_id}', function ($registration_id) {

    $registration_id = urldecode($registration_id);

    $client = \App\Models\Client::with('user')
        ->where('registration_id', $registration_id)
        ->firstOrFail();

    return view('public.verify', compact('client'));

})->name('public.verify');



/*
|--------------------------------------------------------------------------
| SUPER ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])
    ->get('/dashboard/superadmin', [SuperAdminDashboardController::class, 'index'])
    ->name('dashboard.superadmin');

Route::middleware(['auth', 'role:super_admin'])
    ->post('/dashboard/superadmin/toggle-portal', [SuperAdminDashboardController::class, 'togglePortal'])
    ->name('superadmin.toggle.portal');


// Super Admin authentication
Route::get('/super-admin/login', [SuperAdminLoginController::class, 'showLoginForm'])
    ->name('superadmin.login');

Route::post('/super-admin/login', [SuperAdminLoginController::class, 'login'])
    ->name('superadmin.login.post');


// Super Admin management
Route::prefix('super')
    ->name('super.')
    ->middleware(['auth', 'role:super_admin'])
    ->group(function () {

        Route::resource('admins', AdminManagementController::class);

        Route::post('/admins/{id}/toggle', [AdminManagementController::class, 'toggleStatus'])
            ->name('admins.toggle');

        Route::resource('staff', StaffManagementController::class);

        Route::post('/staff/{id}/toggle', [StaffManagementController::class, 'toggle'])
            ->name('staff.toggle');

        Route::resource('clients', SuperAdminClientController::class)
            ->only(['index', 'destroy']);
    });



/*
|--------------------------------------------------------------------------
| SHARED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Messages
    Route::get('/messages', [MessageController::class, 'index'])
        ->name('messages.index');

    Route::get('/messages/create', [MessageController::class, 'create'])
        ->name('messages.create');

    Route::post('/messages', [MessageController::class, 'store'])
        ->name('messages.store');

    Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead'])
        ->name('messages.markRead');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/mark-read', [NotificationController::class, 'markRead'])
        ->name('notifications.markRead');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});


// PDF Reports
Route::get('/pdf/report/{id}', [PdfController::class, 'staffReport'])
    ->middleware('auth')
    ->name('pdf.report');

