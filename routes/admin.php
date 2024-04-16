<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\IssueSpecificationController;
use App\Http\Controllers\Admin\IssueTypeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\VideoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin|superadmin|technician']], function () {
    Route::get('dashboard', [DashboardController::class, 'home'])->name('dashboard');
    Route::resource('tickets', TicketController::class);
    Route::resource('users', UsersController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('faq-categories', FaqCategoryController::class);
    Route::resource('files', FileController::class);
    Route::resource('videos', VideoController::class);

    Route::put('tickets/{id}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
    Route::put('tickets/{id}/change-status', [TicketController::class, 'changeStatus'])->name('tickets.changeStatus');
    Route::get('tickets/{id}/comments', [TicketController::class, 'showComments'])->name('tickets.showComments');
    // report 
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('tickets/{id}/create-report', [ReportController::class, 'create'])->name('tickets.createReport');
    Route::get('tickets/{id}/view-report', [ReportController::class, 'show'])->name('tickets.viewReport');
    Route::get('tickets/{id}/edit-report', [ReportController::class, 'edit'])->name('tickets.editReport');
    Route::post('tickets/store-report', [ReportController::class, 'store'])->name('tickets.storeReport');
    Route::post('tickets/update-report/{reportid}', [ReportController::class, 'update'])->name('tickets.updateReport');

    Route::get('new-tickets', [TicketController::class, 'new'])->name('tickets.new');
    Route::get('in-progress-tickets', [TicketController::class, 'inprogress'])->name('tickets.inprogress');
    Route::get('solved-tickets', [TicketController::class, 'solved'])->name('tickets.solved');
    Route::get('/fetch-specs/{id}/', [TicketController::class, 'fetchSpecs'])->name('tickets.fetchSpecs');
    Route::get('/fetch-subspecs/{id}/', [TicketController::class, 'fetchSubSpecs'])->name('tickets.fetchSubSpecs');
    Route::resource('issue-types', IssueTypeController::class);
    Route::get('issue-types/{id}/create', [IssueTypeController::class, 'specscreate'])->name('issue-types.specs.create');
    Route::put('issue-types/specs/{id}/store', [IssueTypeController::class, 'specsstore'])->name('issue-types.specs.store');
    Route::put('issue-types/specs/{id}/update', [IssueTypeController::class, 'specsupdate'])->name('issue-types.specs.update');
    Route::get('issue-types/specs/{id}/edit', [IssueTypeController::class, 'specsedit'])->name('issue-types.specs.edit');
    Route::delete('issue-types/specs/{id}', [IssueTypeController::class, 'specsdestroy'])->name('issue-types.specs.destroy');
    // sub specs 
    Route::get('issue-types/{issueid}/specs/{specsid}/', [IssueTypeController::class, 'subSpecsIndex'])->name('issue-types.subspecs.index');
    Route::get('issue-types/{issueid}/specs/{specsid}/subspecs/{subspecid}/edit', [IssueTypeController::class, 'subSpecsEdit'])->name('issue-types.subspecs.edit');
    Route::get('issue-types/{issueid}/specs/{specsid}/subspecs/create', [IssueTypeController::class, 'subSpecsCreate'])->name('issue-types.subspecs.create');
    Route::post('issue-types/subspecs/{subspecid}/store', [IssueTypeController::class, 'subSpecsStore'])->name('issue-types.subspecs.store');
    Route::put('issue-types/subspecs/{subspecid}/update', [IssueTypeController::class, 'subSpecsUpdate'])->name('issue-types.subspecs.update');
    Route::delete('issue-types/subspecs/{subspecid}/delete', [IssueTypeController::class, 'subSpecsDestroy'])->name('issue-types.subspecs.destroy');

    // users 
    Route::get('technicians-list', [UsersController::class, 'technicianList'])->name('users.technicianlist');
    Route::get('users-list', [UsersController::class, 'usersList'])->name('users.userslist');

    Route::get('/example', function () {
        return view('emails.admin.new_report');
    });


});