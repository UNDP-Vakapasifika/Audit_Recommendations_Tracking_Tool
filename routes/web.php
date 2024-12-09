<?php

use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\MainstreamCategoryController;
use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\ActionPlanController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuditPractitionerController;
use App\Http\Controllers\CautionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinalReportController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadBodyController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleAndPermissionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SetupController;


// use PDF;

Route::get('/parliament-report', [PdfController::class, 'generateChartsAndPdf'])->name('parliament-report');

Route::get('/login', function () {
    return view('auth.login');
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'index'])->name('home2');

Route::get('/setup', [SetupController::class, 'index'])->name('setup.index');
Route::post('/setup-sai', [SetupController::class, 'setupSAI'])->name('setup.sai');
Route::post('setup/tool', [SetupController::class, 'setupTool'])->name('setup.tool');
Route::post('/setup-admin', [SetupController::class, 'setupAdmin'])->name('setup.admin');

Route::post('/modify', function () {
    return view('metrics');
})->name('modify');

//pdf generator
Route::post('/generate-pdf', [FinalReportController::class, 'generatePdf'])->name('generate.pdf');


Route::middleware(['auth', 'ensure_user_has_changed_password'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Create user
    Route::get('/createuser', [SettingsController::class, 'listUsers'])->name('listUsers');
    Route::post('/createuser', [SettingsController::class, 'storeUser']);

    // Update user
    Route::get('/updateuser/{id}', [SettingsController::class, 'editUser'])->name('updateuser');
    Route::post('/updateuser/{id}', [SettingsController::class, 'updateUser']);

    // Delete user
    Route::get('/deleteuser/{id}', [SettingsController::class, 'deleteUser'])->name('deleteuser');

    // Update implementation status
    Route::post('/update-implementation-status', [SettingsController::class, 'updateImplementationStatus'])
        ->name('update-implementation-status');

    // Update acceptance status
    Route::post('/update-acceptance-status', [SettingsController::class, 'updateAcceptanceStatus'])
        ->name('update-acceptance-status');

    // Update SAI confirmation status
    Route::post('/update-sai-confirmation', [SettingsController::class, 'updateSAIConfirmation'])
        ->name('update-sai-confirmation');

    Route::get('/generate-pdf', function () {
        return redirect()->route('home');
    });

    //Upload Pre final Excel
    Route::post('/upload/recommendations', [RecommendationController::class, 'uploadRecommendations'])->name('upload.recommendations.post');
    Route::get('/upload/recommendations', function () {
        return redirect()->route('recommendations.create');
    });
    
    //Upload final Excel
    Route::post('/upload/report', [RecommendationController::class, 'uploadFinalReport'])->name('upload.recommendations.post2');
    Route::get('/upload/report', function () {
        return redirect()->route('tracking_page');
    });
    //Route::resource('action-plans', ActionPlanController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->withoutMiddleware('ensure_user_has_changed_password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->withoutMiddleware('ensure_user_has_changed_password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Route::get('/upload', [UploadController::class, 'index'])->name('upload');
    //Route::get('/metrics', [MetricsController::class, 'index'])->name('metrics');
    Route::get('/custom-reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/due-date', [ReportController::class, 'reportDueOnTheDate'])->name('reports.due');
    Route::get('/createactionplan', [ActionPlanController::class, 'index'])->name('action_plan1');
    Route::get('/actionplansupervise', [ActionPlanController::class, 'supervise'])->name('supervise');
    Route::get('/actionplansdeclined', [ActionPlanController::class, 'declinedactions'])->name('declined');
    Route::get('/recommendations-tracking', [ActionPlanController::class, 'tracking_index'])->name('tracking_page');
    Route::get('/settings', [SettingsController::class, 'listUsers'])->name('listUsers');
    // Route::get('/practitioners', [AuditPractitionerController::class, 'index'])->name('practitioner');
    // Route::resource('audit-practitioners', AuditPractitionerController::class);
    // Route::get('/audit-practitioners/show', function () {
    //     return view('audit_practitioner_show');
    // })->name('audit-practitioners.show');

    Route::get('/settings', [SetupController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [SetupController::class, 'updateToolSettings'])->name('settings.update');


    Route::post('/action-plans/create', [ActionPlanController::class, 'store2'])->name('createaction2');
    Route::get('/action-plan/{id}/edit', [ActionPlanController::class, 'edit'])->name('action-plan.edit');
    Route::put('/action-plan/{id}', [ActionPlanController::class, 'update'])->name('update-action-plan');
    // Route::put('/action-plan/{id}', [ActionPlanController::class, 'update'])->name('update-action-plan');
    Route::put('/finalreport-change-status/{id}', [FinalReportController::class, 'updateStatus'])->name('updatestatus');
    Route::get('/final_report_edit_status/{id}/edit', [FinalReportController::class, 'editstatus'])->name('status.edit');
    Route::get('/status_change_summary', [FinalReportController::class, 'changeStatusSummary'])->name('status.change.summary');


    Route::get('/dynamicplan', [ActionPlanController::class, 'showActionPlanForm',])->name('dynamicaction');
    Route::get('/get-recommendations/{title}', [ActionPlanController::class, 'getRecommendations']);
    Route::get('/report/{id}', [ActionPlanController::class, 'showReportDetails'])->name('report.details');
    Route::get('/supervisiondetails/{id}', [ActionPlanController::class, 'SuperviseReportDetails'])->name('supervise.details');
    Route::get('/declinedsupervisiondetails/{id}', [ActionPlanController::class, 'declinedactionsdetails'])->name('declined.details');
    Route::patch('/updateactionplan/{id}', [ActionPlanController::class, 'updateactionplan'])->name('updateactionplan');

    Route::get('conversations', [MessagesController::class, 'index'])->name('messages.index');
    Route::post('conversation/start', [MessagesController::class, 'store' ])->name('messages.store')->middleware('log.activity');
    Route::post('conversation/reply', [MessagesController::class, 'reply' ])->name('messages.reply')->middleware('log.activity');
    Route::get('conversations/{conversation:id}', [MessagesController::class, 'show'])->name('messages.show');

    Route::get('/recommendations-tracking/{id}', [ActionPlanController::class, 'showReportDetails2'])->name('report.details2');
    Route::get('/trackingfinalreport/{id}', [ActionPlanController::class, 'showReportDetails3'])->name('report.details3');
    Route::get('/trackingfinalreport/{id}/show', [ActionPlanController::class, 'showReportDetailsView'])->name('report.details.view');
    Route::get('/finalreporteditdetails/{id}', [FinalReportController::class, 'showFinalReportDetails'])->name('final.report.details');
    // Route::get('/finalreporteditdetails/{id}/{status}', [FinalReportController::class, 'showFinalReportDetails'])->name('final.report.details');

    Route::get('/finalreport', [FinalReportController::class, 'showFinalReports'])->name('finalreport');
    Route::get('/finalreportedit', [FinalReportController::class, 'editFinalReports'])->name('edit.finalreport');
    Route::post('/insertfinalreport', [FinalReportController::class, 'insertFinalReports'])->name('insertfinalreport')->middleware('log.activity');
    Route::get('/insertfinalreport', function () {
        return redirect()->route('finalreport');
    });
    Route::get('/unimplementedreport', [FinalReportController::class, 'showUnimplementedReports'])->name('unimplemented.report');
    // Route::get('/audit-reports/preview', [ReportController::class, 'preview'])->name('audit-reports.preview');
    Route::get('/unimplemented-report/download', [ReportController::class, 'download'])->name('audit-reports.download');

    Route::get('/final-recommendations/{id}/edit', [FinalReportController::class, 'edit'])->name('final.recommendations.edit');
    Route::put('/final-recommendations/{id}', [FinalReportController::class, 'update'])->name('final.recommendations.update');

    // Route to edit a recommendation
    Route::get('/recommendations/{recommendation}/edit', [RecommendationController::class, 'edit'])
    ->name('recommendations.edit');
    
    Route::get('/recommendations/details/{report_title}', [RecommendationController::class, 'showDetails'])->name('recommendations.details');

    // Route to update a recommendation
    Route::put('/recommendations/{recommendation}', [RecommendationController::class, 'update'])
    ->name('recommendations.update');
    //notes
    Route::get('/trackingnotes', [NoteController::class, 'reportsshow'])->name('notes.unique.reports');
    Route::get('/trackingnotes/{id}', [NoteController::class, 'showNotesReportDetails'])->name('notes.unique.details');
    Route::get('/trackingnotes/{id}/show', [NoteController::class, 'showNotesDetailsView'])->name('notes.recom.details');
    Route::resource('notes', NoteController::class);
    Route::put('notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::post('final-reports/{final_report_id}/notes', [NoteController::class, 'store'])->name('final-report.notes.store')->middleware('log.activity');
    Route::post('notes/{note}/replies', [NoteController::class, 'storeReply'])->name('notes.replies.store')->middleware('log.activity');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{type}/{resourceId}/{notificationId}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::get('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{id}/delete', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.delete-all');

    Route::get('/send-email-notifications', [ActionPlanController::class, 'sendEmailNotifications'])->name('send.email.notifications');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-log/{userId}', [ActivityLogController::class, 'showLogs'])->name('activity-logs.show');

    // Route::get('/generate-pdf', [FinalReportController::class, 'generatePdf']);
    Route::resource('action-plans', ActionPlanController::class)->except(['show']);
    Route::get('/action-plans/{id}/details', [ActionPlanController::class, 'showReportDetails'])->name('action-plan.details');

    Route::resource('recommendations', RecommendationController::class);
    Route::post('/recommendations/upload', [RecommendationController::class, 'uploadRecommendations'])->name('recommendations.upload.csv');

    Route::get('users/{user}/change-permissions', [UserRoleAndPermissionsController::class, 'changePermissionView'])
        ->name('users.change-permissions-view');
    Route::put('users/{user}/change-permissions', [UserRoleAndPermissionsController::class, 'changePermissions'])
        ->name('users.change-permissions')->middleware('log.activity');
    Route::resource('users', UserController::class);
    Route::get('/users/stakeholder/{id}', [UserController::class, 'showByStakeholder'])->name('users.stakeholder');
    Route::get('/users/client/{id}', [UserController::class, 'showByClient'])->name('users.client');
    Route::post('/users/{user}/make-admin', [UserController::class, 'makeAdmin'])->name('users.makeAdmin')->middleware('log.activity');

    Route::resource('roles', RolesController::class);
    Route::resource('lead-bodies', LeadBodyController::class);
    Route::post('final-report/{id}/caution', [CautionController::class, 'store'])->name('final-report.caution.store')->middleware('log.activity');
    Route::delete('final-report/caution/{caution}', [CautionController::class, 'destroy'])->name('final-report.caution.destroy')->middleware('log.activity');

    Route::resource('client-types', ClientTypeController::class);
    Route::resource('stakeholder', StakeholderController::class);
    Route::resource('mainstream_category', MainstreamCategoryController::class);

    Route::get('/final-report/preview', [RecommendationController::class, 'showPreview'])->name('final_report.preview');
    Route::post('/final-report/confirm', [RecommendationController::class, 'confirm'])->name('final_report.confirm')->middleware('log.activity');

    Route::delete('/finalreport/{id}', [FinalReportController::class, 'destroy'])->name('recommendations.destroy');
    Route::delete('/recommendations/delete/{id}', [RecommendationController::class, 'delete'])->name('recommendations.delete');

});

require __DIR__ . '/auth.php';
