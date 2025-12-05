<?php
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;

Route::get('/clear-view', function() {
    Artisan::call('view:clear');
});

Route::get('/clear-route', function() {
    Artisan::call('route:clear');
});

Route::get('/clear-optimize', function() {
    Artisan::call('optimize');
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
});

Route::get('/m-i-g-r-a-t-e', function() {
    Artisan::call('migrate');
});

Route::get('/migrate-fresh', function() {
    Artisan::call('migrate:fresh');
});

Route::get('/seed', function() {
    Artisan::call('db:seed');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
use App\Http\Controllers\Frontend\ProgramRegisterController;
use App\Http\Controllers\Frontend\ProgramRechargeUpdateController;

Route::get('admin', function () {
    return redirect('login');
});

Auth::routes();
Route::group(['namespace' => 'App\Http\Controllers'], function()
{
	Route::group(['middleware' => ['auth'], 'namespace' => 'Admin'], function()
	{
		Route::get('dashboard', 'Dashboard\DashboardController@index')->name('dashboard');
		Route::resource('content', Content\ContentController::class);
        Route::resource('record', Record\MemberRecordController::class);
        Route::get('/notifications', 'Notification\NotificationController@notifications')->name('notifications');
        Route::post('/notifications/mark-as-read', 'Notification\NotificationController@markAsRead')->name('notifications.markAsRead');
        Route::delete('/notifications/{notification}', 'Notification\NotificationController@delete')->name('notifications.delete');
        Route::resource('event',EventController::class);

        // start program section routes
        Route::resource('program',ProgramController::class);
        Route::resource('program-member',ProgramMemberController::class);
        Route::resource('program-registration',ProgramRegistrationController::class);

        Route::get('/program-members/import', action: 'ProgramMemberController@import')->name('program-member.import');
        Route::post('/program-members/importSave', action: 'ProgramMemberController@importSave')->name('program-member.importSave');
        Route::resource('program-registration',ProgramRegistrationController::class)->names('program-registration');

        // generate registration certificate
        Route::get('/program-registration-certificate-single', action: 'RegistrationCertificatePdfController@generateCertificatePDF')->name('program-registration-certificate-single');
        Route::post('/program-registration-certificate-bulk', action: 'RegistrationCertificatePdfController@generateCertificatePDF')->name('program-registration-certificate-bulk');

        // export registration certificate
        Route::get('/program-registration-export.csv', action: 'ProgramRegistrationController@registrationExportCSV')->name('program-registration.export.csv');

        Route::get('/program-registration-export.excel', action: 'ProgramRegistrationController@registrationExportExcel')->name('program-registration.export.excel');


        // end program section routes
	});

    //frontend
    Route::get('/', 'Frontend\PrivacyController@landingPage')->name('landing');
    Route::get('/privacy-policy', 'Frontend\PrivacyController@index')->name('privacy-policy');
    Route::get('/term-condition', 'Frontend\PrivacyController@termCondition')->name('term-condition');
    Route::get('/coming-soon', 'Frontend\PrivacyController@comingSoon')->name('coming-soon');

    // program registration route
    Route::get('/program-not-found', 'Frontend\PrivacyController@programNotFound')->name('program-not-found');
    Route::get('register-for-program/{alias}', action: [ProgramRegisterController::class, 'registerForProgram'])->name('register-for-program');
    Route::post('register-program-save/{alias}', action: [ProgramRegisterController::class, 'registerProgramSave'])->name('register-program-save');
    Route::get('register-program-success/{alias}', action: [ProgramRegisterController::class, 'registerProgramSuccess'])->name('register-program-success');
    Route::post('register-program-check-field-in-db/{alias?}', action: [ProgramRegisterController::class, 'registerProgramCheckFieldInDB'])->name('register-program-check-field-in-db');
    Route::post('program-user-verify', action: [ProgramRegisterController::class, 'programUserVerify'])->name('program-user-verify');
    Route::post('program-previous-registrations', action: [ProgramRegisterController::class, 'programPreviousRegistrations'])->name('program-previous-registrations');

    Route::get('register-lifestyle-program/{alias}', action: [ProgramRegisterController::class, 'registerForLifeStyleProgram'])->name('register-lifestyle-program');
    Route::post('register-lifestyle-program-check-field-in-db/{alias?}', action: [ProgramRegisterController::class, 'registerLifestyleProgramCheckFieldInDB'])->name('register-lifestyle-program-check-field-in-db');

    // recharge update route
    Route::get('recharge-update-program/{alias}', action: [ProgramRechargeUpdateController::class, 'programRechargeUpdate'])->name('recharge-update-program');
    Route::post('recharge-program-check-field-in-db/{alias?}', action: [ProgramRechargeUpdateController::class, 'programRechargeCheckFieldInDB'])->name('recharge-program-check-field-in-db');
    Route::post('recharge-update-program-save/{alias}', action: [ProgramRechargeUpdateController::class, 'programRechargeUpdateSave'])->name('recharge-update-program-save');

    // disable registration
    Route::get('registration', 'Frontend\RegistrationController@create')->name('registration');

    // show coming soon page
    //    Route::get('registration', function () {
    //      return redirect('coming-soon');
    // })->name('registration');

    Route::post('/register', 'Frontend\RegistrationController@store')->name('register.store');

    Route::post('/verify-user', 'Frontend\RegistrationController@verifyUser')->name('verify-user');
    Route::get('/receipt/{id}', 'Frontend\ReceiptController@show')->name('receipt.show');

    Route::post('/phonepe','Frontend\PhonePeController@phonePe')->name('phonepe');
    Route::any('/phonepe-response','Frontend\PhonePeController@response')->name('response');
    Route::get('/payment-success','Frontend\PhonePeController@successPayment')->name('payment-success');
    Route::post('/payment-success','Frontend\PhonePeController@successPayment')->name('payment-success');

    Route::post('/ccavRequestHandler', 'Frontend\RegistrationController@ccavRequestHandler')->name('ccavRequestHandler');
    Route::get('/ccavCancelHandler', 'Frontend\RegistrationController@ccavCancelHandler')->name('ccavCancelHandler');
    Route::post('/ccavResponseHandler', 'Frontend\RegistrationController@ccavResponseHandler')->name('ccavResponseHandler');

    

});

