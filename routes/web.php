<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
//use App\Http\Controllers\HomeController;



// Auth::routes();

// Route::get('/', function () {
//    return view('welcome');
// });

// Route::middleware(['auth','locale'])->group(function () {
//     //Route::get('/', 'HomeController@index');
//     Route::get('/', [HomeController::class, 'index']);
//     Route::get('/home', [HomeController::class, 'index']);
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/setup', [App\Http\Controllers\HomeController::class, 'setup'])->name('setup');


// Customer
Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index']);
Route::get('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'show']);
Route::get('/customer-datatables', [App\Http\Controllers\CustomerController::class,'datatables']);
Route::get('/customer-export', [App\Http\Controllers\CustomerController::class,'export']);
Route::get('/customer/delete/{id}', [App\Http\Controllers\CustomerController::class,'destroy']);
Route::post('/customer/save', [App\Http\Controllers\CustomerController::class,'store']);
Route::post('/customer/update', [App\Http\Controllers\CustomerController::class,'update']);

 // Vendor
Route::get('/vendor', [App\Http\Controllers\VendorController::class,'index']);
Route::get('/vendor/{id}', [App\Http\Controllers\VendorController::class,'show']);
Route::get('/vendor-datatables', [App\Http\Controllers\VendorController::class,'datatables']);
Route::get('/vendor-export', [App\Http\Controllers\VendorController::class,'export']);
Route::get('/vendor/delete/{id}', [App\Http\Controllers\VendorController::class,'destroy']);
Route::post('/vendor/save', [App\Http\Controllers\VendorController::class,'store']);
Route::post('/vendor/update', [App\Http\Controllers\VendorController::class,'update']);


// Project
Route::get('/project', [App\Http\Controllers\ProjectController::class,'index']);
Route::get('/project/{id}', [App\Http\Controllers\ProjectController::class,'show']);
Route::get('/project-datatables', [App\Http\Controllers\ProjectController::class,'datatables']);
Route::get('/project-export', [App\Http\Controllers\ProjectController::class,'export']);
Route::get('/project/delete/{id}', [App\Http\Controllers\ProjectController::class,'destroy']);
Route::post('/project/save', [App\Http\Controllers\ProjectController::class,'store']);
Route::post('/project/update', [App\Http\Controllers\ProjectController::class,'update']);




 // Department
Route::get('/department/{customerId}', [App\Http\Controllers\McuController::class,'department']);

// Client
Route::get('/client/{customerId}', [App\Http\Controllers\McuController::class,'client']);


 // Users
Route::get('/user', [App\Http\Controllers\UserController::class,'index']);
Route::get('/user/profile', [App\Http\Controllers\UserController::class,'profile']);
Route::get('/user/change-password', [App\Http\Controllers\UserController::class,'changePassword']);
Route::get('/user/setting', [App\Http\Controllers\UserController::class,'setting']);
Route::get('/user/{id}', [App\Http\Controllers\UserController::class,'show']);
Route::get('/user/activate/{id}', [App\Http\Controllers\UserController::class,'activateUser']);
Route::get('/user/inactivate/{id}', [App\Http\Controllers\UserController::class,'inactivateUser']);
Route::get('/user-datatables', [App\Http\Controllers\UserController::class,'datatables']);
Route::get('/user-export', [App\Http\Controllers\UserController::class,'export']);
Route::get('/statistik-umum-paket-export', [App\Http\Controllers\UserController::class,'export']);

Route::post('/user-import', [App\Http\Controllers\UserController::class,'import']);
Route::post('/user/save', [App\Http\Controllers\UserController::class,'store']);
Route::post('/user/update', [App\Http\Controllers\UserController::class,'update']);
Route::post('/user/change-password', [App\Http\Controllers\UserController::class,'storeChangePassword']);
Route::post('/user/update-profile', [App\Http\Controllers\UserController::class,'updateProfile']);
Route::post('/user/setting', [App\Http\Controllers\UserController::class,'storeSetting']);

// User Groups
Route::get('/user-group',  [App\Http\Controllers\UserGroupController::class,'index']);
Route::get('/user-group/disable/',  [App\Http\Controllers\UserGroupController::class,'disable']);
Route::get('/user-group-datatables',  [App\Http\Controllers\UserGroupController::class,'datatables']);
Route::get('/user-group/detail/{id}',  [App\Http\Controllers\UserGroupController::class,'show']);
Route::get('/user-group/disable/{id}',  [App\Http\Controllers\UserGroupController::class,'disableUserGroup']);
Route::get('/user-group/activate/{id}',  [App\Http\Controllers\UserGroupController::class,'activateUserGroup']);
Route::get('/user-group/privileges/{id}',  [App\Http\Controllers\UserGroupController::class,'getPrivileges']);
Route::post('/user-group/privileges',  [App\Http\Controllers\UserGroupController::class,'storePrivileges']);
Route::post('/user-group/save',  [App\Http\Controllers\UserGroupController::class,'store']);
Route::post('/user-group/update',  [App\Http\Controllers\UserGroupController::class,'update']);


    //MCU
    Route::get('/database/medical-check-up',  [App\Http\Controllers\McuController::class,'index']);
    Route::get('/database/medical-check-up/show/{id}', [App\Http\Controllers\McuController::class,'show']);
    Route::get('/database/medical-check-up/delete/{id}', [App\Http\Controllers\McuController::class,'destroy']);
    Route::get('/database/medical-check-up/datatables', [App\Http\Controllers\McuController::class,'datatables']);
    Route::get('/database/medical-check-up/create', [App\Http\Controllers\McuController::class,'create']);
    Route::get('/database/medical-check-up/edit/{id}', [App\Http\Controllers\McuController::class,'edit']);
    Route::post('/database/medical-check-up/store', [App\Http\Controllers\McuController::class,'store']);
    Route::post('/database/medical-check-up/bulk-delete', [App\Http\Controllers\McuController::class,'bulkDelete']);
    Route::post('/database/medical-check-up/export', [App\Http\Controllers\McuController::class,'export'])->name('exportMcu');
    Route::post('/database/medical-check-up/import', [App\Http\Controllers\McuController::class,'import'])->name('importMcu');
    Route::post('/database/medical-check-up/batal-import', [App\Http\Controllers\McuController::class,'cancelImportMcu']);
    Route::post('/database/medical-check-up/publish', [App\Http\Controllers\McuController::class,'publish']);
    //Route::put('/database/medical-check-up/update/{id}', 'McuController@update');
    Route::post('/database/medical-check-up/update', [App\Http\Controllers\McuController::class,'update']);
	Route::get('/database/medical-check-up/show-diagnostic/{id}', [App\Http\Controllers\McuController::class,'showdiagnostic']);
	Route::get('/database/medical-check-up/show-ekg/{id}/{nama}', [App\Http\Controllers\RontgenController::class,'showekg']);
	Route::post('/database/medical-check-up/import-ekg', [App\Http\Controllers\RontgenController::class,'importekg']);
	Route::get('/database/medical-check-up/show-rng/{id}/{nama}', [App\Http\Controllers\RontgenController::class,'showrng']);
	Route::post('/database/medical-check-up/import-rng', [App\Http\Controllers\RontgenController::class,'importrng']);
	Route::post('/database/medical-check-up/diagnostic', [App\Http\Controllers\McuController::class,'diagnostic']);

    //wa
	Route::get('/report-sending-wa/sts-wa/{id}',[App\Http\Controllers\WaController::class,'detail']);
	Route::post('/report-sending-wa/update-wa',[App\Http\Controllers\WaController::class,'updatewa']);
	Route::post('/report-sending-wa/resend-wa',[App\Http\Controllers\WaController::class,'resendwa']);
	Route::get('/report-sending-wa',[App\Http\Controllers\WaController::class,'index']);
	Route::get('/report-sending-wa/datatables', [App\Http\Controllers\WaController::class,'datatables']);
	Route::post('/report-sending-wa/export', [App\Http\Controllers\WaController::class,'export']);
	Route::post('/report-sending-wa/get-new-sts-delivery', [App\Http\Controllers\WaController::class,'newDelivery']);
	Route::post('/report-sending-wa/check-number', [App\Http\Controllers\WaController::class,'checkNumber']);
	Route::post('/report-sending-wa/get-new-status-filter', [App\Http\Controllers\WaController::class,'newDeliveryFilter']);

      // Rontgen
    Route::get('/database/rontgen', [App\Http\Controllers\RontgenController::class,'index']);
    Route::get('/database/rontgen-datatables', [App\Http\Controllers\RontgenController::class,'datatables']);
    Route::get('/database/rontgen/detail/{id}', [App\Http\Controllers\RontgenController::class,'show']);
    Route::get('/database/rontgen/delete/{id}', [App\Http\Controllers\RontgenController::class,'destroy']);
    Route::post('/database/rontgen/save', [App\Http\Controllers\RontgenController::class,'store']);
    Route::post('/database/rontgen/update', [App\Http\Controllers\RontgenController::class,'update']);
    Route::post('/database/rontgen-import', [App\Http\Controllers\RontgenController::class,'import']);
    Route::post('/database/rontgen-export', [App\Http\Controllers\RontgenController::class,'export']);
    Route::post('/database/rontgen-bulk-delete', [App\Http\Controllers\RontgenController::class,'bulkDelete']);

    // Drug Screening
    Route::get('database/drug-screening', [App\Http\Controllers\DrugScreeningController::class,'index']);
    Route::get('database/drug-screening-datatables', [App\Http\Controllers\DrugScreeningController::class,'datatables']);
    Route::post('database/drug-screening/save', [App\Http\Controllers\DrugScreeningController::class,'store']);
    Route::post('database/drug-screening/update', [App\Http\Controllers\DrugScreeningController::class,'update']);
    Route::get('database/drug-screening/detail/{id}', [App\Http\Controllers\DrugScreeningController::class,'show']);
    Route::delete('database/drug-screening/delete/{id}', [App\Http\Controllers\DrugScreeningController::class,'destroy']);
    Route::post('database/drug-screening-export', [App\Http\Controllers\DrugScreeningController::class,'export']);
    Route::post('database/drug-screening-import', [App\Http\Controllers\DrugScreeningController::class,'import']);
    Route::post('/database/drug-screening-bulk-delete', [App\Http\Controllers\DrugScreeningController::class,'bulkDelete']);


    // Audiometri
    Route::get('/database/audiometri', [App\Http\Controllers\AudiometriController::class,'index']);
    Route::get('/database/audiometri-datatables', [App\Http\Controllers\AudiometriController::class,'datatables']);
    Route::post('/database/audiometri/save', [App\Http\Controllers\AudiometriController::class,'store']);
    Route::post('/database/audiometri/update', [App\Http\Controllers\AudiometriController::class,'update']);
    Route::get('/database/audiometri/detail/{id}', [App\Http\Controllers\AudiometriController::class,'show']);
    Route::delete('/database/audiometri/delete/{id}', [App\Http\Controllers\AudiometriController::class,'destroy']);
    Route::post('/database/audiometri-export', [App\Http\Controllers\AudiometriController::class,'export']);
    Route::post('/database/audiometri-import', [App\Http\Controllers\AudiometriController::class,'import']);
    Route::post('/database/audiometri-bulk-delete', [App\Http\Controllers\AudiometriController::class,'bulkDelete']);


    // Formula
    Route::get('/database/parameter', [App\Http\Controllers\HomeController::class,'parameter']);
    Route::get('/database/parameter-data', [App\Http\Controllers\HomeController::class,'parameter_data']);
    Route::post('/database/parameter/update', [App\Http\Controllers\HomeController::class,'update']);
    Route::post('/database/parameter/save', [App\Http\Controllers\HomeController::class,'save']);
    Route::post('/database/parameter/delete', [App\Http\Controllers\HomeController::class,'delete']);
    Route::post('/database/parameter/edit', [App\Http\Controllers\HomeController::class,'edit']);
	Route::post('/database/parameter-kategori}', [App\Http\Controllers\HomeController::class,'kategori']);
	

    Route::get('/database/formula', [App\Http\Controllers\FormulaController::class,'index']);
    Route::get('/database/formula/form-formula', [App\Http\Controllers\FormulaController::class,'form']);
    Route::get('/database/formula/form-formula/{id}', [App\Http\Controllers\FormulaController::class,'formEdit']);
    Route::post('/database/formula/form-formula-getjson-edit', [App\Http\Controllers\FormulaController::class,'get_json_edit_form']);
    Route::get('/database/formula/workHealths-json', [App\Http\Controllers\FormulaController::class,'workHealths']);
    Route::post('/database/formula/insert-formformula', [App\Http\Controllers\FormulaController::class,'inputformula']);
    Route::post('/database/formula/update-formformula', [App\Http\Controllers\FormulaController::class,'updateformula']);
    Route::get('/database/formula/datatables', [App\Http\Controllers\FormulaController::class,'datatables']);
    Route::get('/database/formula/detail/datatables/{id}', [App\Http\Controllers\FormulaController::class,'detailDatatables']);
    Route::get('/database/formula/icdx', [App\Http\Controllers\Icd10Controller::class,'index']);
    Route::get('/database/formula/icdx-search', [App\Http\Controllers\Icd10Controller::class,'search']);
    Route::get('/database/formula/icdx-datatables', [App\Http\Controllers\Icd10Controller::class,'datatables']);
    Route::post('/icd10/update', [App\Http\Controllers\Icd10Controller::class,'update']);
    Route::post('/icd10/save', [App\Http\Controllers\Icd10Controller::class,'create']);
    Route::get('/icd10/delete/{id}', [App\Http\Controllers\Icd10Controller::class,'delete']);
    Route::get('/icd10/{id}', [App\Http\Controllers\Icd10Controller::class,'show']);
    Route::get('/icd10-export', [App\Http\Controllers\Icd10Controller::class,'export']);
	
	
    Route::get('/database/formula/{id}', [App\Http\Controllers\FormulaController::class,'show']);
    Route::get('/database/formula-export', [App\Http\Controllers\FormulaController::class,'export']);
    Route::get('/database/formula/detail/{id}', [App\Http\Controllers\FormulaController::class,'detail']);
    Route::get('/database/formula/detail2/{id}', [App\Http\Controllers\FormulaController::class,'detail2']);
    Route::get('/database/formula/detail-add-modal/{id}', [App\Http\Controllers\FormulaController::class,'add_rumus_detail']);
    Route::post('/database/formula/insert-detail-formula', [App\Http\Controllers\FormulaController::class,'insert_rumus_detail']);
    Route::post('/database/formula/insert-detail-formula-c', [App\Http\Controllers\FormulaController::class,'insert_rumus_detail_c']);


    Route::post('/database/formula/save', [App\Http\Controllers\FormulaController::class,'store']);
    Route::post('/database/formula/update', [App\Http\Controllers\FormulaController::class,'update']);
    Route::post('/database/formula/detail/save', [App\Http\Controllers\FormulaController::class,'storeDetail']);
    Route::post('/database/formula/detail/update', [App\Http\Controllers\FormulaController::class,'updateDetail']);
    Route::post('/database/formula-import', [App\Http\Controllers\FormulaController::class,'import']);
    Route::post('/database/formula/update-detailformula', [App\Http\Controllers\FormulaController::class,'updatedetailformula']);
    Route::post('/database/formula/update-detailformula2', [App\Http\Controllers\FormulaController::class,'updatedetailformula2']);
    Route::post('/database/formula/update-detailformula3', [App\Http\Controllers\FormulaController::class,'updatedetailformula3']);
    Route::post('/database/formula/del22', [App\Http\Controllers\FormulaController::class,'del22']);
    Route::post('/database/formula/insert_rumus_detail_c_per1', [App\Http\Controllers\FormulaController::class,'insert_rumus_detail_c_per1']);
    Route::delete('/database/formula/delete/{id}', [App\Http\Controllers\FormulaController::class,'destroy']);
    Route::get('/database/formula/delete-detail-rumus/{id}/{id_rumus}', [App\Http\Controllers\FormulaController::class,'delete_detail_formula']);
    //Route::get('/database/formula/delete-detail-rumus2/{id}/{id_rumus}', [App\Http\Controllers\FormulaController::class,'delete_detail_formula2']);
    Route::get('/database/formula/delete-rekomendasi-icdx-workdiagnosis/{id}', [App\Http\Controllers\FormulaController::class,'delete_rekomendasi']);


    
     // Menus
    Route::get('/menu', [App\Http\Controllers\MenuController::class,'index']);
    Route::get('/menu/detail/{id}', [App\Http\Controllers\MenuController::class,'show']);
    Route::get('/menu/delete/{id}', [App\Http\Controllers\MenuController::class,'destroy']);
    Route::post('/menu/save', [App\Http\Controllers\MenuController::class,'store']);
    Route::post('/menu/update', [App\Http\Controllers\MenuController::class,'update']);
    Route::post('/menu/build', [App\Http\Controllers\MenuController::class,'build']);

        //Start Menu Reports
    // Medical Check Up
    Route::get('/report/patient/medical-check-up', [App\Http\Controllers\McuController::class,'reportMedicalCheckUp']);
    Route::get('/report/patient/medical-check-up/detail/{id}', [App\Http\Controllers\McuController::class,'reportMedicalCheckUpDetail']);
    Route::get('/report/patient/medical-check-up/print/{id}', [App\Http\Controllers\McuController::class,'printMedicalCheckUpDetail']);
    Route::get('/report/patient/diagnosa-kesehatan-kerja', [App\Http\Controllers\McuController::class,'reportWorkHealthDiagnosis']);
    Route::get('/report/patient/diagnosis-kerja', [App\Http\Controllers\McuController::class,'reportWorkDiagnosis']);
	Route::get('/report/patient/diagnosa-terbanyak', [App\Http\Controllers\McuController::class,'reportMostSuffered']);
    Route::get('/report/patient/elektrokardiografi', [App\Http\Controllers\McuController::class,'reportEkg']);
    Route::get('/report/patient/spirometri', [App\Http\Controllers\McuController::class,'reportSpirometri']);
    Route::get('/report/patient/medical-check-up-datatables', [App\Http\Controllers\McuController::class,'reportMedicalCheckUpDatatables']);
    //Route::get('/report/patient/work-health-diagnosis-datatables', [App\Http\Controllers\McuController::class,'reportWorkHealthDiagnosisDatatables']);
    Route::get('/report/patient/work-health-diagnosis-datatables', [App\Http\Controllers\DiagnosisController::class,'reportWorkHealthDiagnosisDatatables']);
    Route::get('/report/patient/diagnosis-kerja-datatables', [App\Http\Controllers\DiagnosisController::class,'reportAllDiagnosisKerjaDatatables']); //kk
	
    Route::get('/report/patient/most-suffered-datatables', [App\Http\Controllers\McuController::class,'reportMostSufferedDatatables']);
    Route::get('/report/patient/diagnosa-kesehatan-kerja-summary', [App\Http\Controllers\McuController::class,'reportWorkHealthDiagnosisSummaryData']);
    Route::get('/report/patient/elektrokardiografi-datatables', [App\Http\Controllers\McuController::class,'reportEkgDatatables']);
    Route::get('/report/patient/spirometri-datatables', [App\Http\Controllers\McuController::class,'reportSpirometriDatatables']);
    Route::get('/report/patient/elektrokardiografi-summary', [App\Http\Controllers\McuController::class,'reportEkgSummary']);
    Route::get('/report/patient/spirometri-summary', [App\Http\Controllers\McuController::class,'reportSpirometriSummary']);
    Route::get('/report/patient/report/pdf', [App\Http\Controllers\McuController::class,'report']);
    Route::get('/report/patient/report/tes', [App\Http\Controllers\McuController::class,'tes']);
    Route::post('/report/patient/data-audiometri-json', [App\Http\Controllers\McuController::class,'data_audiometri_charts']);
    Route::post('/report/patient/data-spirometri-json', [App\Http\Controllers\McuController::class,'data_spirometri_charts']);
    Route::post('/report/patient/compare-medical-check-up', [App\Http\Controllers\McuController::class,'compareMedicalCheckUp']);
    Route::get('/report/patient/medical-check-up/print-download/{id}', [App\Http\Controllers\McuController::class,'printMedicalCheckUpDetailDownload']);
    Route::get('/report/patient/medical-check-up/print-download2/{id}', [App\Http\Controllers\McuController::class,'printMedicalCheckUpDetailDownload2']);
    Route::get('/report/patient/medical-check-up/print2/{id}', [App\Http\Controllers\McuController::class,'printMedicalCheckUpDetail2']);
    Route::get('/report/patient/medical-check-up/print3/{id}', [App\Http\Controllers\McuController::class,'printMedicalCheckUpDetail3']);

    

    //Export Report MCU Patient
    //Route::get('/report/patient/medical-check-up/export/pdf/{id}', 'McuController@exportReportPersonalMedicalCheckUp');
	Route::post('/report/patient/medical-check-up/export', [App\Http\Controllers\McuController::class,'export2']);//->name('exportMcu');
	Route::post('/report/patient/diagnosa-kerja/export', [App\Http\Controllers\McuController::class,'exportKeskerja']);
	Route::post('/report/patient/diagnosa-kesehatan-kerja/export', [App\Http\Controllers\McuController::class,'export3']);  
	Route::post('/report/patient/most-suffered/export', [App\Http\Controllers\McuController::class,'export4']);
	Route::post('/report/patient/ekg/export', [App\Http\Controllers\McuController::class,'export5']);

    // Diagnosis
    Route::get('/report/top-ten-diseases', [App\Http\Controllers\DiagnosisController::class,'reportTopTenDiagnosis']);
    Route::get('/report/all-diseases', [App\Http\Controllers\DiagnosisController::class,'reportAllDiagnosis']);
    Route::get('/report/top-ten-diseases-datatables', [App\Http\Controllers\DiagnosisController::class,'reportTopTenDiagnosisDatatables']);
    Route::get('/report/all-diseases-datatables', [App\Http\Controllers\DiagnosisController::class,'reportAllDiagnosisDatatables']);
    Route::get('/report/all-diseases-kerja-datatables', [App\Http\Controllers\DiagnosisController::class,'reportAllDiagnosisKerjaDatatables']);
    Route::get('/report/top-ten-diseases-data', [App\Http\Controllers\DiagnosisController::class,'reportTopTenDiagnosisData']);
	Route::post('/report/top-ten/export', [App\Http\Controllers\DiagnosisController::class,'export']);
	Route::post('/report/all-diseases/export', [App\Http\Controllers\DiagnosisController::class,'export_all_diseases']);
	//Route::get('/report/diseases-detail/{code}/{total}/{parentMenu?}', [App\Http\Controllers\DiagnosisController::class,'reportDiagnosisDetail']);
	Route::get('/report/diseases-detail/{code}/{total}/{parentMenu?}/{filter}', [App\Http\Controllers\DiagnosisController::class,'reportDiagnosisDetail']);
	Route::get('/report/diseases-detail-datatables', [App\Http\Controllers\DiagnosisController::class,'reportDiseasesDatatables']);
    Route::post('/report/patient/diseases-detail/export', [App\Http\Controllers\DiagnosisController::class,'exportDetaildiagnosis']);
    Route::get('/report/all-diseases-dkk', [App\Http\Controllers\DiagnosisController::class,'reportAllDiagnosisDkk']);
    Route::get('/report/all-diseases-datatables-dkk', [App\Http\Controllers\DiagnosisController::class,'reportAllDiagnosisDatatablesDkk']);
    Route::post('/report/patient/diseases-detail-dkk/export', [App\Http\Controllers\DiagnosisController::class,'exportDetaildiagnosisDkk']);

    Route::get('/report/diseases-detail-dkk/{code}/{total}/{parentMenu?}/{filter}', [App\Http\Controllers\DiagnosisController::class,'reportDiagnosisDetailDkk']);
    Route::get('/report/diseases-detail-datatables-dkk', [App\Http\Controllers\DiagnosisController::class,'reportDiseasesDatatablesDkk']);
    Route::post('/report/all-diseases-dkk/export', [App\Http\Controllers\DiagnosisController::class,'export_all_diseases_dkk']);
    
    
    // Audiometri
    Route::get('/report/patient/audiometri',[App\Http\Controllers\McuController::class,'reportAudiometri']);
    Route::get('/report/patient/audiometri-summary',[App\Http\Controllers\McuController::class,'reportAudiometriSummary']);
    Route::get('/report/patient/audiometri-datatables',[App\Http\Controllers\McuController::class,'reportAudiometriDatatables']);
	Route::post('/report/patient/audiometri-export',[App\Http\Controllers\McuController::class,'exportAudiometri']); 
	Route::post('/report/patient/spirometri-export',[App\Http\Controllers\McuController::class,'exportSpirometri']); 

    // Radiologi
    Route::get('/report/patient/radiologi',[App\Http\Controllers\McuController::class,'reportRadiology']);
    Route::get('/report/patient/radiologi-summary',[App\Http\Controllers\McuController::class,'reportRadiologySummary']);
    Route::get('/report/patient/radiologi-datatables',[App\Http\Controllers\McuController::class,'reportRadiologyDatatables']);
    Route::post('/report/radiology/export',[App\Http\Controllers\McuController::class,'exportRadiology']);

    // Drug Screening
    Route::get('/report/patient/drug-screening',[App\Http\Controllers\McuController::class,'reportDrugScreening']);
    Route::get('/report/patient/drug-screening-summary',[App\Http\Controllers\McuController::class,'reportDrugScreeningSummary']);
    Route::get('/report/patient/drug-screening-datatables',[App\Http\Controllers\McuController::class,'reportDrugScreeningDatatables']);
	Route::post('/report/patient/drug-screening-export',[App\Http\Controllers\McuController::class,'exportDrugScreening']); 

    // Statistik Umum
    Route::get('/report/statistik-umum',[App\Http\Controllers\McuController::class,'reportStatistic']);
    Route::get('/report/statistik-sex',[App\Http\Controllers\McuController::class,'reportSexSummary']);
    Route::get('/report/statistik-age',[App\Http\Controllers\McuController::class,'reportAgeSummary']);
    Route::get('/report/statistik-event',[App\Http\Controllers\McuController::class,'reportEventSummary']);
    Route::get('/report/statistik-event-sex',[App\Http\Controllers\McuController::class,'reportEventSexSummary']);
    Route::get('/report/statistik-paket-datatables',[App\Http\Controllers\McuController::class,'reportPaketDatatables']);
    Route::get('/report/statistik-bagian-datatables',[App\Http\Controllers\McuController::class,'reportBagianDatatables']);
    Route::get('/report/statistik-client-datatables',[App\Http\Controllers\McuController::class,'reportClientDatatables']);
    Route::get('/report/statistik-detail/{tabel}/{nilai}/{total}/{parentMenu?}/{filter}', [App\Http\Controllers\DiagnosisController::class,'reportStatistikaDetail']);
	Route::get('/report/statistik-detail-datatables', [App\Http\Controllers\DiagnosisController::class,'reportStatistikaDetailDatatables']); 
    Route::post('/report/patient/statistik-detail/export', [App\Http\Controllers\DiagnosisController::class,'exportDetailStatistika']);
    Route::get('/statistik-umum-paket-export/{orderPaket}/{filterPaket}', [App\Http\Controllers\UserController::class,'statistik_umum_paket_export']);  
    Route::get('/statistik-umum-bagian-export/{orderPaket}/{filterPaket}', [App\Http\Controllers\UserController::class,'statistik_umum_bagian_export']);
    Route::get('/statistik-umum-client-export/{orderPaket}/{filterPaket}', [App\Http\Controllers\UserController::class,'statistik_umum_client_export']);
    // Finish Menu Reports

    // Tools
    Route::get('/tools/backup-database', [App\Http\Controllers\ToolsController::class,'backupDatabase']);
    Route::get('/tools/backup-database-command/{nama}', [App\Http\Controllers\ToolsController::class,'serverDBBackup']);
    Route::get('/tools/restore-database', [App\Http\Controllers\ToolsController::class,'restoreDatabase']);
    Route::post('/tools/restore-database-command', [App\Http\Controllers\ToolsController::class,'restore']);
    Route::get('/tools/capture', [App\Http\Controllers\ToolsController::class,'capture']);
    Route::get('/tools/truncate', [App\Http\Controllers\ToolsController::class,'truncatetable']);
    Route::get('/tools/truncate-by-id-process/{id}', [App\Http\Controllers\ToolsController::class,'byIdDelete']);
    Route::get('/tools/move-log', [App\Http\Controllers\ToolsController::class,'moveLog']);
    Route::get('/tools/delete-log', [App\Http\Controllers\ToolsController::class,'deleteLog']);
	Route::get('/tools/delete-proses-by-id/{id}', [App\Http\Controllers\ToolsController::class,'deleteProsesBysID']);


    // Documentation
    Route::get('/documentation/{page}', function($page) {
        if (view()->exists('pages.documentation.' . $page)) {
            return view('pages.documentation.' . $page);
        }
        abort(404);
    });
	
	Route::get('/tes-pdf', [App\Http\Controllers\HomeController::class,'tespdf']);


    // Sign Dokter
    Route::get('/sign-dokter', [App\Http\Controllers\SignDokterController::class,'index']); 
    Route::post('/sign-dokter/saveAudio', [App\Http\Controllers\SignDokterController::class,'saveAudio']);
    Route::post('/sign-dokter/saveRontgen', [App\Http\Controllers\SignDokterController::class,'saveRontgen']);
    Route::post('/sign-dokter/saveEkg', [App\Http\Controllers\SignDokterController::class,'saveEkg']);
    Route::post('/sign-dokter/saveSpiro', [App\Http\Controllers\SignDokterController::class,'saveSpiro']);



// Route without authentication for general purpose
// like when execute on job queue, get part of data
Route::get('/database/audiometri-chart/{mcuId}',[App\Http\Controllers\AudiometriController::class,'chart']);
Route::get('/update-process/{processId}', [App\Http\Controllers\ProcessController::class,'updateProcess']);
Route::get('/update-process3/{processId}', [App\Http\Controllers\ProcessController::class,'updateProcess3']);
Route::get('/update-process-wa/{processId}', [App\Http\Controllers\ProcessController::class,'updateProcessWa']);
Route::get('/report-mcu/{id}', [App\Http\Controllers\McuController::class,'publishMedicalCheckUpDetailForWA']);

