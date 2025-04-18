<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::namespace('App\Http\Controllers')->name('api.')->group(function(){

    
    Route::prefix('/base')->name('base.')->group(function () {
        Route::get('/', 'BaseController@index')->name('index');
        Route::get('/set-lang/{lang}','BaseController@setLang');
        Route::get('/barcode', 'BaseController@barcode')->name('barcode');
        Route::get('/timezone', 'BaseController@timezone')->name('timezone');
    });
    
    Route::post('/login', 'AuthController@login')->name("login");

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', 'AuthController@logout')->name("logout");

        Route::prefix('/profile')->name('profile.')->group(function () {
            Route::get('/', 'ProfileController@index')->name('index');
            Route::post('/update','ProfileController@update')->name('update');
            Route::post('/password','ProfileController@password')->name('password');
            Route::get('/device', 'ProfileController@device')->name('device');
            Route::post('/device/disconect','ProfileController@deviceDisconnect')->name('device.disconect');
        });

        Route::namespace('Settings')->prefix('/settings')->group(function () {

            Route::prefix('/user')->name('user.')->group(function () {
                Route::get('/', 'UserController@index')->name('index');
                Route::post('/store','UserController@store')->name('store');
                Route::get('/{id}', 'UserController@show')->name('show');
                Route::put('/{id}/update','UserController@update')->name('update');
                Route::delete('/{id}/delete','UserController@destroy')->name('delete');
            });
            
            Route::prefix('/permissions')->name('permissions.')->group(function () {
                Route::get('/', 'PermissionController@index')->name('index');
                Route::get('/list', 'PermissionController@list')->name('list');
                Route::post('/store','PermissionController@store')->name('store');
                Route::get('/{id}', 'PermissionController@show')->name('show');
                Route::put('/{id}/update','PermissionController@update')->name('update');
                Route::delete('/{id}/delete','PermissionController@destroy')->name('delete');
            });
            
            Route::prefix('/job_position')->name('job_position.')->group(function () {
                Route::get('/', 'JobPositionController@index')->name('index');
                Route::post('/store','JobPositionController@store')->name('store');
                Route::get('/{id}', 'JobPositionController@show')->name('show');
                Route::put('/{id}/update','JobPositionController@update')->name('update');
                Route::delete('/{id}/delete','JobPositionController@destroy')->name('delete');
            });
            
            Route::prefix('/grade')->name('grade.')->group(function () {
                Route::get('/', 'GradeController@index')->name('index');
                Route::post('/store','GradeController@store')->name('store');
                Route::get('/{id}', 'GradeController@show')->name('show');
                Route::put('/{id}/update','GradeController@update')->name('update');
                Route::delete('/{id}/delete','GradeController@destroy')->name('delete');
            });
            
            Route::prefix('/expertise')->name('expertise.')->group(function () {
                Route::get('/', 'ExpertiseController@index')->name('index');
                Route::post('/store','ExpertiseController@store')->name('store');
                Route::get('/{id}', 'ExpertiseController@show')->name('show');
                Route::put('/{id}/update','ExpertiseController@update')->name('update');
                Route::delete('/{id}/delete','ExpertiseController@destroy')->name('delete');
            });

            Route::prefix('/department')->name('department.')->group(function () {
                Route::get('/', 'DepartmentController@index')->name('index');
                Route::post('/store','DepartmentController@store')->name('store');
                Route::get('/{id}', 'DepartmentController@show')->name('show');
                Route::put('/{id}/update','DepartmentController@update')->name('update');
                Route::delete('/{id}/delete','DepartmentController@destroy')->name('delete');
            });

            Route::prefix('/general')->name('general.')->group(function () {
                Route::get('/', 'SystemController@general');
                Route::post('/update','SystemController@generalUpdate');
            });
            
            Route::prefix('/email')->name('email.')->group(function () {
                Route::get('/', 'SystemController@email');
                Route::post('/update','SystemController@emailUpdate');
            });

        });
        
        Route::prefix('/employee')->name('employee.')->group(function () {
            Route::get('/', 'EmployeeController@index')->name('index');
            Route::get('/create', 'EmployeeController@create')->name('create');
            Route::post('/store','EmployeeController@store')->name('store');
            Route::get('/data', 'EmployeeController@data')->name('data');
            Route::get('/{id}', 'EmployeeController@show')->name('show');
            Route::get('/{id}/edit','EmployeeController@edit')->name('edit');
            Route::post('/{id}/update','EmployeeController@update')->name('update');
            Route::delete('/{id}/delete','EmployeeController@destroy')->name('delete');
        });
        
        Route::namespace('Employee')->group(function () {

            Route::prefix('/employee-stats')->name('employee-stats.')->group(function () {
                Route::get('/department', 'StatsController@department');
                Route::get('/status', 'StatsController@index');
                Route::get('/gender', 'StatsController@gender');
                Route::get('/join', 'StatsController@join');
                Route::get('/status', 'StatsController@status');
            });

            Route::prefix('/family')->name('family.')->group(function () {
                Route::get('/', 'FamilyController@index')->name('index');
                Route::post('/store','FamilyController@store')->name('store');
                Route::get('/{id}', 'FamilyController@show')->name('show');
                Route::post('/{id}/update','FamilyController@update')->name('update');
                Route::delete('/{id}/delete','FamilyController@destroy')->name('delete');
            });
            
            Route::prefix('/education')->name('education.')->group(function () {
                Route::get('/', 'EducationController@index')->name('index');
                Route::post('/store','EducationController@store')->name('store');
                Route::get('/{id}', 'EducationController@show')->name('show');
                Route::post('/{id}/update','EducationController@update')->name('update');
                Route::delete('/{id}/delete','EducationController@destroy')->name('delete');
            });

            Route::prefix('/experience')->name('experience.')->group(function () {
                Route::get('/', 'ExperienceController@index')->name('index');
                Route::post('/store','ExperienceController@store')->name('store');
                Route::get('/{id}', 'ExperienceController@show')->name('show');
                Route::post('/{id}/update','ExperienceController@update')->name('update');
                Route::delete('/{id}/delete','ExperienceController@destroy')->name('delete');
            });
            Route::prefix('/bank-account')->name('bank_account.')->group(function () {
                Route::get('/', 'BankAccountController@index')->name('index');
                Route::post('/store','BankAccountController@store')->name('store');
                Route::get('/{id}', 'BankAccountController@show')->name('show');
                Route::post('/{id}/update','BankAccountController@update')->name('update');
                Route::delete('/{id}/delete','BankAccountController@destroy')->name('delete');
            });
            
            Route::prefix('/certification')->name('certification.')->group(function () {
                Route::get('/', 'CertificationController@index')->name('index');
                Route::post('/store','CertificationController@store')->name('store');
                Route::get('/{id}', 'CertificationController@show')->name('show');
                Route::post('/{id}/update','CertificationController@update')->name('update');
                Route::delete('/{id}/delete','CertificationController@destroy')->name('delete');
            });
            
            Route::prefix('/agreement')->name('agreement.')->group(function () {
                Route::get('/', 'AgreementController@index')->name('index');
                Route::post('/store','AgreementController@store')->name('store');
                Route::get('/{id}', 'AgreementController@show')->name('show');
                Route::post('/{id}/update','AgreementController@update')->name('update');
                Route::delete('/{id}/delete','AgreementController@destroy')->name('delete');
            });

            Route::prefix('/insurance')->name('insurance.')->group(function () {
                Route::get('/', 'InsuranceController@index')->name('index');
                Route::post('/store','InsuranceController@store')->name('store');
                Route::get('/{id}', 'InsuranceController@show')->name('show');
                Route::post('/{id}/update','InsuranceController@update')->name('update');
                Route::delete('/{id}/delete','InsuranceController@destroy')->name('delete');
            });
            
            Route::prefix('/medical')->name('medical.')->group(function () {
                Route::get('/', 'MedicalController@index')->name('index');
                Route::post('/store','MedicalController@store')->name('store');
                Route::get('/{id}', 'MedicalController@show')->name('show');
                Route::post('/{id}/update','MedicalController@update')->name('update');
                Route::delete('/{id}/delete','MedicalController@destroy')->name('delete');
            });

            Route::prefix('/attachment')->name('attachment.')->group(function () {
                Route::get('/', 'AttachmentController@index')->name('index');
                Route::post('/store','AttachmentController@store')->name('store');
                Route::get('/{id}', 'AttachmentController@show')->name('show');
                Route::post('/{id}/update','AttachmentController@update')->name('update');
                Route::delete('/{id}/delete','AttachmentController@destroy')->name('delete');
            });
        });
        
    });
});

