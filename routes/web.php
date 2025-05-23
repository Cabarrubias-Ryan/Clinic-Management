<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\icons\RiIcons;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\layouts\Container;

use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\records\RecordsController;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\diagnosis\DiagnosisController;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\appointment\AppointmentController;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;

// Main Page Route

Route::get('/', [LoginBasic::class, 'index'])->name('login');
Route::post('/login', [LoginBasic::class, 'login'])->name('login-process');
Route::get('/logout', [LoginBasic::class, 'logoutAccount'])->name('logout');


Route::get('auth/dashboard-analytics', [Analytics::class, 'index'])->name('dashboard-analytics');


Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::post('/auth/register-basic/add', [RegisterBasic::class, 'store'])->name('auth-register-basic-add');
Route::post('/auth/register-basic/update', [RegisterBasic::class, 'update'])->name('auth-register-basic-update');
Route::post('/auth/register-basic/delete', [RegisterBasic::class, 'delete'])->name('auth-register-basic-delete');

Route::get('/auth/appointment-basic', [AppointmentController::class, 'index'])->name('auth-appointment-basic');
Route::post('/auth/appointment-basic/add', [AppointmentController::class, 'store'])->name('auth-appointment-basic-add');
Route::post('/auth/appointment-basic/update', [AppointmentController::class, 'update'])->name('auth-appointment-basic-update');
Route::post('/auth/appointment-basic/delete', [AppointmentController::class, 'delete'])->name('auth-appointment-basic-delete');

Route::get('/auth/record-basic', [RecordsController::class, 'index'])->name('auth-records-basic');

Route::get('/auth/diagnosis-basic', [DiagnosisController::class, 'index'])->name('auth-diagnosis-basic');
Route::post('/auth/diagnosis-basic/add', [DiagnosisController::class, 'add'])->name('auth-diagnosis-basic-add');

Route::get('/auth/diagnosis-basic/complete', [DiagnosisController::class, 'complete'])->name('auth-diagnosis-basic-complete');
Route::get('/auth/diagnosis-basic/cancel', [DiagnosisController::class, 'cancel'])->name('auth-diagnosis-basic-cancel');



// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
