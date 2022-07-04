<?php

use App\Models\config;
use App\Models\Project\Project;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


if (env('APP_DEBUG') === true) {
    Route::get('/test', function(){
        $project = Project::find(1)->projectInformation->getInformation();
        dump($project);exit;
    });

    Route::get('/test2', function() {
        $ocid = 'ocds-2q8bt1-1';
        $projectInformation = \App\Models\Project\ProjectInformation::where('ocid', $ocid)->with('project')->first();
        $project = $projectInformation->project;

        $projectMilestones = \App\Http\Controllers\ApiController::getProjectMilestones($project);
        $announcements = \App\Http\Controllers\ApiController::getProjectAnnouncements($project);
        $procurementDocuments = \App\Http\Controllers\ApiController::getProjectProcurementDocuments($project);
        $financialStructure = \App\Http\Controllers\ApiController::getProjectFinancialStructure($project);
        $risks = \App\Http\Controllers\ApiController::getProjectRisks($project);
        $governmentSupport = \App\Http\Controllers\ApiController::getProjectGovernmentSupport($project);
        $tariffs = \App\Http\Controllers\ApiController::getProjectTariffs($project);
        $terminationProvisions = \App\Http\Controllers\ApiController::getProjectTerminationProvisions($project);
        $performancesFailures = \App\Http\Controllers\ApiController::getProjectPerformanceFailures($project);

        // julio
        $renegotiations = \App\Http\Controllers\ApiController::getRenegotiations($project);
        $redactedPPP = \App\Http\Controllers\ApiController::getRedactedPPPAgreement($project);
        $environment = $project->projectDetails->environment->description;

        dump(\App\Http\Controllers\ApiController::getProjectRisksDocuments($project));exit;
    });

    Route::get('/test/{ocid}', [
        'as' => 'api.test',
        'uses' => 'ApiController@test'
    ]);

    /*
     * Route for preview emails
     */ 
    Route::get('/email/newsletter', function(){

        return view('emails/user/newsletteremail', ['name' => 'Nombre']);
    });

    Route::get('/reg/email', function(){

        return view('back.emails.user.registrationEmail', ['name' => 'Nombre','email'=>'asd@ads.es','password'=>'12314']);
    });


    Route::get('/email/contact-default', function(){

        return view('emails/contact/default', ['name' => 'Nombre','subject'=>'Asunto','email'=>'email@email.com','text'=>'This is a email text']);
    });

    Route::get('/email/newsletter-default', function(){

        return view('emails/newsletter/default', ['name' => 'Nombre','subject'=>'Asunto','email'=>'email@email.com','text'=>'This is a email text']);
    });

    Route::get('/email/register', function(){

        return view('emails/user/register', ['name' => 'Nombre', 'link' => 'sad']);
    });

    Route::get('/newsletter/tasks', function(){

        return view('/emails/user/registernewsletter', ['link' => 'adasd', 'password' => 'asdadasdasdad','section' => 'sector','project' => 'asdasdasd', 'description' => 'lorem ipsulum bla bla bla bla blabla', 'document' => 'document', 'name' => 'Nombre', 'subject' => 'sad', 'text' => 'test', 'email' => 'a@a.com']);
    });    
}


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

/*Route::post('/registerUser', 'Auth\RegisterController@customRegister');*/


/*
 |--------------------------------------------------------------------------
 |  Back-End Routes Block
 |--------------------------------------------------------------------------
 |
 | Within this block, the end-back routes are registered.
 |
 |
 */


/**
 * Uploader Routing
 */
Route::get('/uploader/init', 'UploaderController@initFiles');
Route::post('/uploader', 'UploaderController@storeUpload');
Route::delete('/uploader/delete/{uuid}', 'UploaderController@deleteUpload');

/**
 * Search Routing
 */
Route::get('/search/{q}/{w}', [
    'as'   => 'search/query',
    'uses' => 'SearchableController@search'
]);

/**
 * Analytics Routing
 */
Route::group(['prefix' => 'analytics'], function() {

    Route::get('dashboard', [
        'as' => 'analytics.dashboard',
        'uses' => 'AnalyticsController@index'
    ]);

});

//Get image gallery of a project
Route::get('/uploader/g/{id_image}', 'UploaderController@getGalleryImage')->name('uploader.g');
//Get logo of a party
Route::get('/uploader/par/{position}', 'UploaderController@getEntityLogo')->name('uploader.par');
//Get slider image
Route::get('/uploader/s/{position}', 'UploaderController@getSliderImage')->name('uploader.s');
//Get banner image
Route::get('/uploader/b/{position}', 'UploaderController@getBannerImage')->name('uploader.b');
//Get logo
Route::get('/storage/logo', 'UploaderController@getLogo')->name('application.logo');
//Get any media
Route::get('/media/{id}', 'UploaderController@getMedia')->name('application.media');
//Get projectfile
Route::get('/projectfile/{id}', 'UploaderController@getProjectFile')->name('application.file');
//Get any mystery file
Route::get('/mysterybox/{id}', 'UploaderController@getMystery')->name('application.mystery');
//Get all files in a project
Route::post('/project-all/{id}', 'UploaderController@getAllProjectFiles')->name('project.all-files');

Route::group(['prefix' => 'admin'], function(){

    Route::post('projectListLike', [
        'as'   => 'admin-find-projects-by-like',
        'uses' => 'Backend\AdminController@likeProjects'
    ]);

    Route::post('usersListLike', [
        'as'   => 'admin-find-users-by-like',
        'uses' => 'Backend\AdminController@likeUsers'
    ]);

    Route::post('usersListLikeExceptViewOnly', [
        'as'   => 'admin-find-users-except-viewOnly-by-like',
        'uses' => 'Backend\AdminController@likeUsersExceptViewOnly'
    ]);

    Route::post('usersListLikeRole', [
        'as'   => 'admin.usersListLikeRole',
        'uses' => 'Backend\AdminController@likeUsersRole'
    ]);


    Route::get('projectSectionsList', [
        'as'   => 'admin.projectSectionsList',
        'uses' => 'Backend\AdminController@projectSectionsList'
    ]);

    Route::get('projectSectionsPositionsList', [
        'as'   => 'admin.projectSectionsPositionsList',
        'uses' => 'Backend\AdminController@projectSectionsPositionsList'
    ]);

    Route::post('usersValidateEmail', [
        'as'   => 'admin-validate-new-user-email',
        'uses' => 'Backend\UserController@emailExists'
    ]);

    Route::post('usersValidateEmailEdit', [
        'as'   => 'users.validate.email.edit',
        'uses' => 'Backend\UserController@emailExistsEdit'
    ]);

});

Route::group(['prefix' => 'roles-permissions'], function(){

    Route::get('/', [
        'as'   => 'roles.roles-permissions',
        'uses' => 'Backend\RolesPermissionsController@index'
    ]);

    Route::post('/save-edit', [
        'as'   => 'roles-save-edit',
        'uses' => 'Backend\RolesPermissionsController@save'
    ]);

    Route::post('/save-new', [
        'as'   => 'roles-save-new',
        'uses' => 'Backend\RolesPermissionsController@saveNew'
    ]);

    Route::post('/delete', [
        'as'   => 'roles-delete',
        'uses' => 'Backend\RolesPermissionsController@delete'
    ]);

    Route::post('/check', [
        'as'   => 'roles-check',
        'uses' => 'Backend\RolesPermissionsController@checkRole'
    ]);



});

Route::group(['prefix' => 'users'], function(){

    Route::get('/', [
        'as'   => 'edit-users',
        'uses' => 'Backend\UserController@index'
    ]);
    Route::post('usersValidateEmail', [
        'as'   => 'admin-validate-new-user-email',
        'uses' => 'Backend\UserController@emailExists'
    ]);
    Route::post('storeUser', [
        'as'   => 'users.store',
        'uses' => 'Backend\UserController@store'
    ]);
    Route::post('updateUser', [
        'as'   => 'users.update',
        'uses' => 'Backend\UserController@update'
    ]);
    Route::post('deleteUser', [
        'as'   => 'users.delete',
        'uses' => 'Backend\UserController@delete'
    ]);
    Route::post('userFindByRole', [
        'as'   => 'user.findByRole',
        'uses' => 'Backend\UserController@findByRole'
    ]);
    Route::post('findByRoleAndAdmin', [
        'as'   => 'user.findByRoleAndAdmin',
        'uses' => 'Backend\UserController@findByRoleAndAdmin'
    ]);

    Route::post('findPermissions', [
        'as'   => 'user.findPermissions',
        'uses' => 'Backend\UserController@findPermissions'
    ]);
     Route::post('findDataEntriesGeneric', [
        'as'   => 'user.findDataEntriesGeneric',
        'uses' => 'Backend\UserController@findDataEntriesGeneric'
    ]);

    /*
     * Data-tables routes
     */

    Route::post('users/tableUsers', [
        'as'   => 'users.tableUsers',
        'uses' => 'Backend\UserController@table'
    ]);

    Route::post('users/inactive', [
        'as'   => 'users.inactive',
        'uses' => 'Backend\UserController@inactive'
    ]);


});

/**
 * Deleted Users
 */


Route::group(['prefix' => 'deleted-users'], function(){


    Route::get('/', [
        'as'   => 'users.deleted',
        'uses' => 'Backend\DeletedUsersController@index'
    ]);

    Route::post('/table', [
        'as'   => 'users.deleted.table',
        'uses' => 'Backend\DeletedUsersController@table'
    ]);

});



Route::get('/roles', [
    'as'   => 'roles-permissions',
    'uses' => 'Backend\AdminController@roles'
]);

Route::post('projects', [
    'as'   => 'roles-permissions',
    'uses' => 'Backend\AdminController@roles'
]);


Route::get('/dashboard', [
    'as'   => 'dashboard',
    'uses' => 'Backend\DashboardController@index'

]);


/*
 * Settings
 */

Route::group(['prefix' => 'settings'], function(){
    Route::get('/', [
        'as'   => 'general-settings',
        'uses' => 'Backend\SettingsController@index'
    ]);

    Route::post('/theme/new', [
        'as'   => 'general-settings/theme/new',
        'uses' => 'Backend\SettingsController@createTheme'

    ]);

    Route::post('/theme/save', [
        'as'   => 'general-settings/theme/save',
        'uses' => 'Backend\SettingsController@saveTheme'

    ]);

    Route::post('/theme/active', [
        'as'   => 'general-settings/theme/active',
        'uses' => 'Backend\SettingsController@activeTheme'

    ]);

    Route::post('/theme/delete', [
        'as'   => 'general-settings/theme/delete',
        'uses' => 'Backend\SettingsController@deleteTheme'

    ]);

    Route::post('/theme/get', [
        'as'   => 'general-settings/theme/get',
        'uses' => 'Backend\SettingsController@getThemeSchema'

    ]);

    Route::post('/logo', [
        'as'   => 'general-settings/logo',
        'uses' => 'Backend\SettingsController@uploadLogo'

    ]);


    Route::post('/nav/create', [
        'as'   => 'general-settings/nav/create',
        'uses' => 'Backend\SettingsController@createNavigationItem'

    ]);

    Route::post('/nav/save', [
        'as'   => 'general-settings/nav/save',
        'uses' => 'Backend\SettingsController@saveNavigationItem'

    ]);

    Route::post('/nav/delete', [
        'as'   => 'general-settings/nav/delete',
        'uses' => 'Backend\SettingsController@deleteNavigationItem'

    ]);



    Route::post('/api', [
        'as'   => 'general-settings/api',
        'uses' => 'Backend\SettingsController@setApi'

    ]);

    Route::post('/db/backup', [
        'as'   => 'general-settings/db/backup',
        'uses' => 'Backend\SettingsController@backupDb'

    ]);

    Route::post('/currency/save', [
        'as'   => 'general-settings.currency-save',
        'uses' => 'Backend\SettingsController@saveCurrency'

    ]);

    Route::post('/publisher/save', [
        'as'   => 'general-settings.publisher-save',
        'uses' => 'Backend\SettingsController@savePublisherData'

    ]);



});

/**
 *  Activity Log
 */

Route::group(['prefix' => 'activity-log'], function(){
    Route::get('/', [
        'as'   => 'activity_log',
        'uses' => 'Backend\ActivityLogController@index'
    ]);

    Route::post('/table', [
        'as'   => 'activity_log_table',
        'uses' => 'Backend\ActivityLogController@table'
    ]);

});

/*
 * Entities
 */

Route::group(['prefix' => 'entities'], function(){

    Route::get('/', [
        'as' => 'entities',
        'uses' => 'Backend\EntityController@index'
    ]);

    Route::post('/store', [
        'as' => 'store-entity',
        'uses' => 'Backend\EntityController@store'
    ]);


    Route::post('/update', [
        'as' => 'update-entity',
        'uses' => 'Backend\EntityController@update'
    ]);

    Route::post('/publish', [
        'as' => 'publish-entity',
        'uses' => 'Backend\EntityController@publish'
    ]);

    Route::delete('/delete', [
        'as' => 'delete-entity',
        'uses' => 'Backend\EntityController@delete'
    ]);

});

Route::group(['prefix' => 'sliders'], function(){

    Route::get('/', [
        'as'   => 'sliders',
        'uses' => 'Backend\WebsiteManagementController@sliderIndex'
    ]);
    Route::post('/store', [
        'as' => 'sliders/store',
        'uses' => 'Backend\WebsiteManagementController@sliderStore'
    ]);
    Route::post('/edit', [
        'as' => 'sliders/edit',
        'uses' => 'Backend\WebsiteManagementController@sliderEdit'
    ]);

    Route::post('/active', [
        'as' => 'sliders/active',
        'uses' => 'Backend\WebsiteManagementController@sliderActive'
    ]);

    Route::delete('/delete/', [
        'as' => 'sliders/delete',
        'uses' => 'Backend\WebsiteManagementController@sliderRemove'
    ]);

    Route::post('/projectInfo', [
        'as'   => 'get-project-info',
        'uses' => 'Backend\WebsiteManagementController@getProjectInfo'
    ]);


});

/**
* Banners
**/
Route::group(['prefix' => 'banners'], function(){

    Route::get('/', [
        'as'   => 'banners',
        'uses' => 'Backend\WebsiteManagementController@bannerIndex'
    ]);
    Route::post('/store', [
        'as' => 'banners/store',
        'uses' => 'Backend\WebsiteManagementController@bannerStore'
    ]);
    Route::post('/edit', [
        'as' => 'banners/edit',
        'uses' => 'Backend\WebsiteManagementController@bannerEdit'
    ]);

    Route::post('/active', [
        'as' => 'banners/active',
        'uses' => 'Backend\WebsiteManagementController@bannerActive'
    ]);

    Route::delete('/delete/', [
        'as' => 'banners/delete',
        'uses' => 'Backend\WebsiteManagementController@bannerRemove'
    ]);

});


Route::group(['prefix' => 'graphs'], function(){

    Route::get('/', [
        'as'   => 'graphs',
        'uses' => 'Backend\WebsiteManagementController@graphIndex'
    ]);

    Route::post('/edit', [
        'as' => 'graphs/edit',
        'uses' => 'Backend\WebsiteManagementController@graphUpdate'
    ]);



});


Route::group(['prefix' => 'website-management'], function(){

    Route::group(['prefix' => 'global-announcements'], function(){

        Route::get('/', [
            'as'   => 'admin.global-announcements',
            'uses' => 'Backend\GlobalAnnouncementsController@index'
        ]);
        Route::post('tableAnnouncements', [
            'as'   => 'admin.global-announcements.tableAnnouncements',
            'uses' => 'Backend\GlobalAnnouncementsController@table'
        ]);
        Route::get('/new', [
            'as'   => 'admin.global-announcements-new',
            'uses' => 'Backend\GlobalAnnouncementsController@newAnnouncement'
        ]);
        Route::get('/edit/{id}', [
            'as'   => 'admin.global-announcements-edit',
            'uses' => 'Backend\GlobalAnnouncementsController@edit'
        ]);
        Route::post('/store', [
            'as' => 'admin.global-announcements-store',
            'uses' => 'Backend\GlobalAnnouncementsController@store'
        ]);

        Route::delete('/delete/', [
            'as' => 'admin.global-announcements-delete',
            'uses' => 'Backend\GlobalAnnouncementsController@delete'
        ]);

    });

});


/*
|--------------------------------------------------------------------------
|  FOOTER ROUTES BLOCK
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'footer'], function(){
    Route::get('/', [
        'as'   => 'footer',
        'uses' => 'Backend\WebsiteManagementController@footer'
    ]);

    Route::post('/contact-save', [
        'as'   => 'footer.contact',
        'uses' => 'Backend\WebsiteManagementController@contactInfoSave'
    ]);

    Route::post('/social-save', [
        'as'   => 'footer.social',
        'uses' => 'Backend\WebsiteManagementController@socialSave'
    ]);
});


Route::group(['prefix' => 'about-ppp'], function(){

  Route::post('/edit', [
      'as'   => 'about-ppp/edit',
      'uses' => 'Backend\WebsiteManagementController@aboutPPPEdit'
  ]);
});

/*
|--------------------------------------------------------------------------
|  END FOOTER ROUTES BLOCK
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
|  USER ROUTES BLOCK
|--------------------------------------------------------------------------
*/

Route::get('/change-password', [
    'as'   => 'change-password',
    'uses' => 'Backend\UserController@passwordChange'
]);

Route::post('/change-password/store', [
    'as' => 'change-password.store',
    'uses' => 'Backend\UserController@storePassword'
]);

/*
|--------------------------------------------------------------------------
|  END USER ROUTES BLOCK
|--------------------------------------------------------------------------
*/


/**
 *  ADD PROJECT ROUTES
 */

Route::group(['prefix' => 'projects'], function(){

    Route::get('/', [
        'as'   => 'add-project',
        'uses' => 'Backend\AddProjectController@addProjects'
    ]);

    Route::get('/import', [
        'as'   => 'import-project',
        'uses' => 'Backend\ImportProjectController@index'
    ]);


    Route::post('/import', [
        'as'   => 'import-project',
        'uses' => 'Backend\ImportProjectController@import'
    ]);

    Route::get('/import/template', [
        'as'   => 'import-project-download',
        'uses' => 'Backend\ImportProjectController@download'
    ]);

    Route::post('/store', [
        'as' => 'add-project/store',
        'uses' => 'Backend\AddProjectController@store'
    ]);
    Route::post('/delete', [
        'as' => 'add-project/delete',
        'uses' => 'Backend\AddProjectController@deleteProject'
    ]);
    Route::post('checkOCID', [
        'as'   => 'project-check-ocid',
        'uses' => 'Backend\Project\ProjectController@ocidExists'
    ]);

    /*
     * Data-tables routes
     */

    Route::post('tableProjects', [
        'as'   => 'add-projects.tableProjects',
        'uses' => 'Backend\AddProjectController@table'
    ]);


});

/**
 * PROJECT DETAILS
 */
Route::group(['prefix' => 'project'], function(){

    /**
     * PROJECT VISIBILITY
     */
    Route::post('change-visibility', [
        'as'   => 'project-change-visibility',
        'uses' => 'Backend\Project\ProjectController@changeVisibility'
    ]);

    /**
     * PROJECT NAME
     */
    Route::post('change-name', [
        'as'   => 'project-change-name',
        'uses' => 'Backend\Project\ProjectController@changeName'
    ]);

    /**
     * Contract documents
     */
    Route::get('{id}/contract-information/documents', [
        'as'   => 'project-details-documents',
        'uses' => 'Backend\Project\ProjectDetails\PD_DocumentController@index'
    ]);

    Route::post('/contract-information/documents/store', [
        'as'   => 'project-details-documents/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_DocumentController@store'
    ]);

    Route::post('/contract-information/documents/edit', [
        'as'   => 'project-details-documents/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_DocumentController@edit'
    ]);

    Route::post('/contract-information/documents/order', [
        'as'   => 'project-details-documents/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_DocumentController@order'
    ]);

    Route::post('/contract-information/documents/visibility', [
        'as'   => 'project-details-documents/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_DocumentController@visibility'
    ]);

    Route::delete('/contract-information/documents/delete', [
        'as'   => 'project-details-documents/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_DocumentController@delete'
    ]);

    /*
     * PROJECT ENVIRONMENT
     */

    Route::get('{id}/contract-information/environment', [
        'as'   => 'project-details-environment',
        'uses' => 'Backend\Project\ProjectDetails\PD_EnvironmentController@index'
    ]);

    Route::post('/project-details/environment/store', [
        'as'   => 'project-details-environment/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_DEnvironmentController@store'
    ]);

    Route::post('/project-details/environment/edit', [
        'as'   => 'project-details-environment/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_EnvironmentController@edit'
    ]);

    Route::post('/project-details/environment/visibility', [
        'as'   => 'project-details-environment/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_EnvironmentController@visibility'
    ]);

    Route::delete('/project-details/environment/delete', [
        'as'   => 'project-details-environment/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_EnvironmentController@delete'
    ]);


    /**
     * PROJECT ANNOUNCEMENTS
     */
    Route::get('{id}/announcements', [
        'as'   => 'project-details-announcements',
        'uses' => 'Backend\Project\ProjectDetails\PD_AnnouncementController@index'
    ]);

    Route::post('/project-details/announcements/store', [
        'as'   => 'project-details-announcements/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_AnnouncementController@store'
    ]);

    Route::post('/project-details/announcements/edit', [
        'as'   => 'project-details-announcements/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_AnnouncementController@edit'
    ]);

    Route::post('/project-details/announcements/visibility', [
        'as'   => 'project-details-announcements/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_AnnouncementController@visibility'
    ]);

    Route::delete('/project-details/announcements/delete', [
        'as'   => 'project-details-announcements/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_AnnouncementController@delete'
    ]);


    /**
     * CONTRACT SUMMARY
     */
    Route::get('{id}/contract-information/contract-summary', [
        'as'   => 'project-details-contract-summary',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractSummaryController@index'
    ]);

    Route::post('/project-details/contract-summary/store', [
        'as'   => 'project-details-contract-summary/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractSummaryController@store'
    ]);

    Route::post('/project-details/contract-summary/edit', [
        'as'   => 'project-details-contract-summary/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractSummaryController@edit'
    ]);

    Route::post('/project-details/contract-summary/order', [
        'as'   => 'project-details-contract-summary/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractSummaryController@order'
    ]);

    Route::post('/project-details/contract-summary/visibility', [
        'as'   => 'project-details-contract-summary/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractSummaryController@visibility'
    ]);

    Route::delete('/project-details/contract-summary/delete', [
        'as'   => 'project-details-contract-summary/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractSummaryController@delete'
    ]);

    /**
     * PROJECT PROCUREMENT
     */
    Route::get('{id}/procurement', [
        'as'   => 'project.procurement',
        'uses' => 'Backend\Project\ProjectDetails\PD_ProcurementController@index'
    ]);

    Route::post('/project-details/procurement/store', [
        'as'   => 'procurement/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_ProcurementController@store'
    ]);

    Route::post('/project-details/procurement/edit', [
        'as'   => 'procurement/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_ProcurementController@edit'
    ]);

    Route::delete('/project-details/procurement/delete', [
        'as'   => 'procurement/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_ProcurementController@delete'
    ]);

    Route::post('/project-details/procurement/order', [
        'as'   => 'procurement/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_ProcurementController@order'
    ]);

    Route::post('/project-details/procurement/visibility', [
        'as'   => 'procurement/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_ProcurementController@visibility'
    ]);

    /**
     * PROJECT RISKS
     */
    Route::get('{id}/contract-information/risks', [
        'as'   => 'project-details-risks',
        'uses' => 'Backend\Project\ProjectDetails\PD_RiskController@index'
    ]);

    Route::post('/project-details/risks/store', [
        'as'   => 'project-details-risks/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_RiskController@store'
    ]);

    Route::post('/project-details/risks/edit', [
        'as'   => 'project-details-risks/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_RiskController@edit'
    ]);

    Route::post('/project-details/risks/order', [
        'as'   => 'project-details-risks/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_RiskController@order'
    ]);

    Route::post('/project-details/risks/visibility', [
        'as'   => 'project-details-risks/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_RiskController@visibility'
    ]);

    Route::delete('/project-details/risks/delete', [
        'as'   => 'project-details-risks/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_RiskController@delete'
    ]);

    /**
     * PROJECT EVALUATION PPP
     */
    Route::get('{id}/contract-information/evaluation-ppp', [
        'as'   => 'project-details-evaluation-ppp',
        'uses' => 'Backend\Project\ProjectDetails\PD_EvaluationController@index'
    ]);

    Route::post('/project-details/evaluation-ppp/store', [
        'as'   => 'project-details-evaluation-ppp/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_EvaluationController@store'
    ]);

    Route::post('/project-details/evaluation-ppp/edit', [
        'as'   => 'project-details-evaluation-ppp/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_EvaluationController@edit'
    ]);

    Route::delete('/project-details/evaluation-ppp/delete', [
        'as'   => 'project-details-evaluation-ppp/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_EvaluationController@delete'
    ]);

    /**
     * PROJECT FINANCIALS
     */
    Route::get('{id}/contract-information/financial', [
        'as'   => 'project-details-financial',
        'uses' => 'Backend\Project\ProjectDetails\PD_FinancialController@index'
    ]);

    Route::post('/project-details/financial/store', [
        'as'   => 'project-details-financial/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_FinancialController@store'
    ]);

    Route::post('/project-details/financial/edit', [
        'as'   => 'project-details-financial/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_FinancialController@edit'
    ]);

    Route::post('/project-details/financial/order', [
        'as'   => 'financial/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_FinancialController@order'
    ]);

    Route::post('/project-details/financial/visibility', [
        'as'   => 'financial/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_FinancialController@visibility'
    ]);


    Route::delete('/project-details/financial/delete', [
        'as'   => 'project-details-financial/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_FinancialController@delete'
    ]);

    /**
     * PROJECT GOVERNMENT SUPPORT
     */
    Route::get('{id}/contract-information/government-support', [
        'as'   => 'project-details-government-support',
        'uses' => 'Backend\Project\ProjectDetails\PD_GovernmentSupportController@index'
    ]);

    Route::post('/project-details/government-support/store', [
        'as'   => 'project-details-government-support/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_GovernmentSupportController@store'
    ]);

    Route::post('/project-details/government-support/edit', [
        'as'   => 'project-details-government-support/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_GovernmentSupportController@edit'
    ]);

    Route::post('/project-details/government-support/order', [
        'as'   => 'project-details-government-support/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_GovernmentSupportController@order'
    ]);

    Route::post('/project-details/government-support/visibility', [
        'as'   => 'project-details-government-support/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_GovernmentSupportController@visibility'
    ]);

    Route::delete('/project-details/government-support/delete', [
        'as'   => 'project-details-government-support/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_GovernmentSupportController@delete'
    ]);


    /**
     * PROJECT TARIFFS
     */
    Route::get('{id}/contract-information/tariffs', [
        'as'   => 'project-details-tariffs',
        'uses' => 'Backend\Project\ProjectDetails\PD_TariffsController@index'
    ]);

    Route::post('/project-details/tariffs/store', [
        'as'   => 'project-details-tariffs/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_TariffsController@store'
    ]);

    Route::post('/project-details/tariffs/edit', [
        'as'   => 'project-details-tariffs/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_TariffsController@edit'
    ]);

    Route::post('/project-details/tariffs/order', [
        'as'   => 'project-details-tariffs/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_TariffsController@order'
    ]);

    Route::post('/project-details/tariffs/visibility', [
        'as'   => 'project-details-tariffs/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_TariffsController@visibility'
    ]);

    Route::delete('/project-details/tariffs/delete', [
        'as'   => 'project-details-tariffs/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_TariffsController@delete'
    ]);

    /**
     * PROJECT Terminal Provisions
     */
    Route::get('{id}/contract-information/termination-provisions', [
        'as'   => 'project-details-contract-termination',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractTerminationController@index'
    ]);

    Route::post('/project-details/contract-termination/store', [
        'as'   => 'project-details-contract-termination/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractTerminationController@store'
    ]);

    Route::post('/project-details/contract-termination/edit', [
        'as'   => 'project-details-contract-termination/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractTerminationController@edit'
    ]);

    Route::post('/project-details/contract-termination/order', [
        'as'   => 'project-details-contract-termination/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractTerminationController@order'
    ]);

    Route::post('/project-details/contract-termination/visibility', [
        'as'   => 'project-details-contract-termination/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractTerminationController@visibility'
    ]);

    Route::delete('/project-details/contract-termination/delete', [
        'as'   => 'project-details-contract-termination/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_ContractTerminationController@delete'
    ]);

    /**
     * PROJECT AWARD
     */
    Route::get('{id}/contract-information/award', [
        'as'   => 'project-details-award',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@index'
    ]);

    Route::post('/project-details/award/store-core', [
        'as'   => 'project-details-award/store-core',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@storeCore'
    ]);

    Route::post('/project-details/award/store-bidder', [
        'as'   => 'project-details-award/store-bidder',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@storeBidder'
    ]);

    Route::post('/project-details/award/store-financing', [
        'as'   => 'project-details-award/store-financing',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@storeFinancial'
    ]);

    Route::post('/project-details/award/edit-financing', [
        'as'   => 'project-details-award/edit-financing',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@editFinancial'
    ]);

    Route::delete('/project-details/award/delete-financing', [
        'as'   => 'project-details-award/delete-financing',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@delete'
    ]);

    Route::post('/project-details/award/visibility', [
        'as'   => 'project-details-award/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@visibility'
    ]);

    Route::delete('/project-details/award/delete', [
        'as'   => 'project-details-award/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@deleteBidder'
    ]);

    Route::post('/project-details/award/order', [
        'as'   => 'project-details-award/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_AwardController@order'
    ]);


    /*
     * Excel importing features
     */
    Route::get('{id}/excel', [
        'as'   => 'project-export-excel',
        'uses' => 'Backend\AddProjectController@exportToExcel'
    ]);

    Route::get('excel/import', [
        'as'   => 'project-import-excel',
        'uses' => 'Backend\AddProjectController@importFromExcel'
    ]);


    /**
     * PROJECT RENEGOTIATIONS
     */
    Route::get('{id}/contract-information/renegotiations', [
        'as'   => 'project-details-renegotiations',
        'uses' => 'Backend\Project\ProjectDetails\PD_RenegotiationsController@index'
    ]);

    Route::post('/project-details/renegotiations/store', [
        'as'   => 'project-details-renegotiations/store',
        'uses' => 'Backend\Project\ProjectDetails\PD_RenegotiationsController@store'
    ]);

    Route::post('/project-details/renegotiations/edit', [
        'as'   => 'project-details-renegotiations/edit',
        'uses' => 'Backend\Project\ProjectDetails\PD_RenegotiationsController@edit'
    ]);

    Route::post('/project-details/renegotiations/order', [
        'as'   => 'project-details-renegotiations/order',
        'uses' => 'Backend\Project\ProjectDetails\PD_RenegotiationsController@order'
    ]);

    Route::post('/project-details/renegotiations/visibility', [
        'as'   => 'project-details-renegotiations/visibility',
        'uses' => 'Backend\Project\ProjectDetails\PD_RenegotiationsController@visibility'
    ]);

    Route::delete('/project-details/renegotiations/delete', [
        'as'   => 'project-details-renegotiations/delete',
        'uses' => 'Backend\Project\ProjectDetails\PD_RenegotiationsController@delete'
    ]); 
});


/**
 * PROJECT ROUTES
 */

Route::group(['prefix' => 'project'], function(){

    /*
     * Project information
     */
    Route::get('{id}/project-information', [
        'as' => 'project.project-information',
        'uses' => 'Backend\Project\ProjectInformationController@index'
    ]);
    Route::post('project-informationEdit', [
        'as' => 'project.project-information.edit',
        'uses' => 'Backend\Project\ProjectInformationController@edit'
    ]);
    Route::post('project-informationEditCore', [
        'as' => 'project.project-information.editCore',
        'uses' => 'Backend\Project\ProjectInformationController@editCore'
    ]);
    Route::post('project-informationStore', [
        'as' => 'project.project-information.store',
        'uses' => 'Backend\Project\ProjectInformationController@store'
    ]);
    Route::post('check-ocid', [
        'as' => 'project.check-ocid',
        'uses' => 'Backend\Project\ProjectInformationController@ocidExists'
    ]);
    Route::post('project-informationIndividualVisibility', [
        'as'   => 'project.project-informationIndividualVisibility',
        'uses' => 'Backend\Project\ProjectInformationController@changeIndividualVisibility'
    ]);

    Route::post('active', [
        'as' => 'project.active',
        'uses' => 'Backend\AddProjectController@active'
    ]);


/*
* Party
*/
    Route::get('{id_project}/parties',[
      'as' => 'project.parties',
      'uses' => 'Backend\Project\PartyController@index'
    ]);

    Route::post('{id_project}/parties/update',[
        'as' => 'project-parties/update',
        'uses' => 'Backend\Project\PartyController@update'
    ]);

    Route::post('{id_project}/parties/store',[
        'as' => 'project.parties.store',
        'uses' => 'Backend\Project\PartyController@store'
    ]);

    Route::post('{id_project}/parties/publish',[
        'as' => 'project.parties.publish',
        'uses' => 'Backend\Project\PartyController@publish'
    ]);


    Route::delete('parties/delete',[
        'as' => 'project.parties.delete',
        'uses' => 'Backend\Project\PartyController@delete'
    ]);


/*
     * Gallery
     */


    Route::get('{id_project}/gallery',[
        'as' => 'project.gallery',
        'uses' => 'Backend\Project\GalleryController@index'
    ]);

    Route::post('{id_project}/gallery',[
        'as' => 'project.gallery',
        'uses' => 'Backend\Project\GalleryController@index'
    ]);

    Route::post('/gallery/add',[
        'as' => 'project.gallery.add',
        'uses' => 'Backend\Project\GalleryController@addFromGallery'
    ]);
    Route::post('/gallery/upload',[
        'as' => 'project.gallery.upload',
        'uses' => 'Backend\Project\GalleryController@addFile'
    ]);
    Route::delete('/gallery/remove',[
        'as' => 'project.gallery.remove',
        'uses' => 'Backend\Project\GalleryController@remove'
    ]);

    /*
    |--------------------------------------------------------------------------
    |  CONTRACT MILESTONES ROUTES BLOCK
    |--------------------------------------------------------------------------
    */

    Route::get('{id}/project-milestones', [
        'as' => 'project.contract-milestones',
        'uses' => 'Backend\Project\ContractMilestonesController@index'
    ]);
    Route::post('project-contract-milestones-store', [
        'as' => 'project.contract-milestones.store',
        'uses' => 'Backend\Project\ContractMilestonesController@store'
    ]);
    Route::post('project-contract-milestones-update', [
        'as' => 'project.contract-milestones.update',
        'uses' => 'Backend\Project\ContractMilestonesController@update'
    ]);
    Route::delete('project-contract-milestones-delete', [
        'as'   => 'project.contract-milestones.delete',
        'uses' => 'Backend\Project\ContractMilestonesController@delete'
    ]);
    Route::post('project-contract-milestones-visibility', [
        'as'   => 'project.contract-milestones.visibility',
        'uses' => 'Backend\Project\ContractMilestonesController@visibility'
    ]);
    /*
    |--------------------------------------------------------------------------
    |  END CONTRACT MILESOTNES ROUTES
    |--------------------------------------------------------------------------
    */




    /*
    |--------------------------------------------------------------------------
    |  PERFORMANCE ROUTES BLOCK
    |--------------------------------------------------------------------------
    */

    /*
    * Annual demand levels
    */
    Route::get('{id}/performance-information/annual-demand-levels', [
        'as' => 'project.performance-information.annual-demand-levels',
        'uses' => 'Backend\Project\PerformanceInformation\AnualDemandLevelsController@index'
    ]);
    Route::post('project.performance-information.annual-demand-levels.store', [
       'as' => 'project.performance-information.annual-demand-levels.store',
       'uses' => 'Backend\Project\PerformanceInformation\AnualDemandLevelsController@store'
    ]);
    Route::post('project.performance-information.annual-demand-levels.update', [
       'as' => 'project.performance-information.annual-demand-levels.update',
       'uses' => 'Backend\Project\PerformanceInformation\AnualDemandLevelsController@update'
    ]);

    Route::post('project.performance-information.annual-demand-levels.delete', [
       'as' => 'project.performance-information.annual-demand-levels.delete',
       'uses' => 'Backend\Project\PerformanceInformation\AnualDemandLevelsController@delete'
    ]);

    Route::post('project.performance-information.annual-demand-levels.storeType', [
       'as' => 'project.performance-information.annual-demand-levels.storeType',
       'uses' => 'Backend\Project\PerformanceInformation\AnualDemandLevelsController@storeType'
    ]);

     /*
     * Income statement metrics
     */
    Route::get('{id}/performance-information/income-statement-metrics', [
        'as' => 'project.performance-information.income-statements-metrics',
        'uses' => 'Backend\Project\PerformanceInformation\IncomeStatementsMetricsController@index'
    ]);
    Route::post('project.performance-information.income-statements-metrics', [
        'as' => 'project.performance-information.income-statements-metrics.store',
        'uses' => 'Backend\Project\PerformanceInformation\IncomeStatementsMetricsController@store'
    ]);
    Route::post('project.performance-information.income-statements-metricsUpdate', [
        'as' => 'project.performance-information.income-statements-metrics.update',
        'uses' => 'Backend\Project\PerformanceInformation\IncomeStatementsMetricsController@update'
    ]);
    Route::post('project.performance-information.income-statements-metricsDelete', [
        'as' => 'project.performance-information.income-statements-metrics.delete',
        'uses' => 'Backend\Project\PerformanceInformation\IncomeStatementsMetricsController@delete'
    ]);
    Route::post('project.performance-information.income-statements-metricsType', [
        'as' => 'project.performance-information.income-statements-metrics.storeType',
        'uses' => 'Backend\Project\PerformanceInformation\IncomeStatementsMetricsController@storeType'
    ]);

    /*
    * Other financial metrics
    */
   Route::get('{id}/performance-information/other-financial-metrics', [
       'as' => 'project.performance-information.other-financial-metrics',
       'uses' => 'Backend\Project\PerformanceInformation\OtherFinancialMetricsController@index'
   ]);
    Route::post('project.performance-information.other-financial-metrics-storeAnnual', [
       'as' => 'project.performance-information.other-financial-metrics.storeAnnual',
       'uses' => 'Backend\Project\PerformanceInformation\OtherFinancialMetricsController@storeAnnual'
    ]);
    Route::post('project.performance-information.other-financial-metrics-updateAnnual', [
       'as' => 'project.performance-information.other-financial-metrics.updateAnnual',
       'uses' => 'Backend\Project\PerformanceInformation\OtherFinancialMetricsController@updateAnnual'
    ]);
    Route::post('project.performance-information.other-financial-metrics-deleteAnnual', [
       'as' => 'project.performance-information.other-financial-metrics.deleteAnnual',
       'uses' => 'Backend\Project\PerformanceInformation\OtherFinancialMetricsController@deleteAnnual'
    ]);

    Route::post('project.performance-information.other-financial-metrics-storeTimelessType', [
        'as' => 'project.performance-information.other-financial-metrics.storeTimelessType',
        'uses' => 'Backend\Project\PerformanceInformation\OtherFinancialMetricsController@storeTimelessType'
    ]);
    Route::post('project.performance-information.other-financial-metrics-storeTimeless', [
        'as' => 'project.performance-information.other-financial-metrics.storeTimeless',
        'uses' => 'Backend\Project\PerformanceInformation\OtherFinancialMetricsController@storeTimeless'
    ]);

    Route::post('project.performance-information.other-financial-metrics-storeAnnualType', [
        'as' => 'project.performance-information.other-financial-metrics.storeAnnualType',
        'uses' => 'Backend\Project\PerformanceInformation\OtherFinancialMetricsController@storeAnnualType'
    ]);


    /*
     * Key performance indicators
     */
    Route::get('{id}/performance-information/key-performance-indicators', [
        'as' => 'project.performance-information.key-performance-indicators',
        'uses' => 'Backend\Project\PerformanceInformation\KeyPerformanceIndicatorsController@index'
    ]);
    Route::post('project.performance-information.key-performance-indicators', [
        'as' => 'project.performance-information.key-performance-indicators.store',
        'uses' => 'Backend\Project\PerformanceInformation\KeyPerformanceIndicatorsController@store'
    ]);
    Route::post('project.performance-information.key-performance-indicators-Delete', [
        'as' => 'project.performance-information.key-performance-indicators.Delete',
        'uses' => 'Backend\Project\PerformanceInformation\KeyPerformanceIndicatorsController@Delete'
    ]);
    Route::post('project.performance-information.key-performance-indicators-updateStore', [
        'as' => 'project.performance-information.key-performance-indicators.updateStore',
        'uses' => 'Backend\Project\PerformanceInformation\KeyPerformanceIndicatorsController@updateStore'
    ]);
    Route::post('project.performance-information.key-performance-indicatorsstoreType', [
        'as' => 'project.performance-information.key-performance-indicators.storeType',
        'uses' => 'Backend\Project\PerformanceInformation\KeyPerformanceIndicatorsController@storeType'
    ]);



    /*
     * Performance failures
     */
    Route::get('{id}/performance-information/performance-failures', [
        'as' => 'project.performance-information.performance-failures',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceFailureController@index'
     ]);
    Route::post('project.performance-information.performance-failures', [
        'as' => 'project.performance-information.performance-failures.store',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceFailureController@store'
    ]);
    Route::post('project.performance-information.performance-failures-storeCategory', [
        'as' => 'project.performance-information.performance-failures.storeCategory',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceFailureController@storeCategory'
    ]);
    Route::post('project.performance-information.performance-failuresUpdate', [
        'as' => 'project.performance-information.performance-failures.update',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceFailureController@update'
    ]);
    Route::post('project.performance-information.performance-failuresOrder', [
        'as' => 'project.performance-information.performance-failures.order',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceFailureController@order'
    ]);
    Route::post('project.performance-information.performance-failuresVisibility', [
        'as' => 'project.performance-information.performance-failures.visibility',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceFailureController@visibility'
    ]);
    Route::delete('project.performance-information.performance-failuresDelete', [
        'as' => 'project.performance-information.performance-failures.delete',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceFailureController@delete'
    ]);

    /*
     * Performance assessments
     */

    Route::get('{id}/performance-information/performance-assessments', [
        'as' => 'project.performance-information.performance-assessments',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceAssessmentsController@index'
     ]);
    Route::post('project.performance-information.performance-assessments', [
        'as' => 'project.performance-information.performance-assessments.store',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceAssessmentsController@store'
    ]);
    Route::post('project.performance-information.performance-assessmentsUpdate', [
        'as' => 'project.performance-information.performance-assessments.update',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceAssessmentsController@update'
        ]);
    Route::post('project.performance-information.performance-assessmentsOrder', [
        'as' => 'project.performance-information.performance-assessments.order',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceAssessmentsController@order'
    ]);
    Route::post('project.performance-information.performance-assessmentsVisibility', [
        'as' => 'project.performance-information.performance-assessments.visibility',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceAssessmentsController@visibility'
    ]);
    Route::delete('project.performance-information.performance-assessmentsDelete', [
        'as' => 'project.performance-information.performance-assessments.delete',
        'uses' => 'Backend\Project\PerformanceInformation\PerformanceAssessmentsController@delete'
    ]);


    /*
    |--------------------------------------------------------------------------
    |  END PERFORMANCE ROUTES
    |--------------------------------------------------------------------------
    */



});
/**
 * TASKS ROUTES
 */

Route::group(['prefix' => 'tasks'], function(){

    Route::get('/', [
        'as'   => 'tasks-management',
        'uses' => 'Backend\TaskController@index'
    ]);


    Route::post('decline', [
        'as'   => 'tasks.decline',
        'uses' => 'Backend\TaskController@decline'
    ]);

    Route::post('accept', [
        'as'   => 'tasks.accept',
        'uses' => 'Backend\TaskController@accept'
    ]);

    Route::post('confirmation', [
        'as'   => 'tasks.confirm',
        'uses' => 'Backend\TaskController@confirm'
    ]);

    Route::post('edit', [
        'as'   => 'tasks.edit',
        'uses' => 'Backend\TaskController@edit'
    ]);

    Route::post('delete', [
        'as'   => 'tasks.delete',
        'uses' => 'Backend\TaskController@delete'
    ]);

    /*
     * Data-tables routes
     */
    Route::post('tableTasks', [
        'as'   => 'tasks.tableTasks',
        'uses' => 'Backend\TaskController@table'

    ]);

});


/**
 * REQUEST FOR MODIFICATION
 */

Route::group(['prefix' => 'request-modification'], function(){

    Route::post('/store', [
        'as'   => 'request-modification/store',
        'uses' => 'Backend\RequestModificationController@store'
    ]);

});

/*
 |--------------------------------------------------------------------------
 |  End Back-End Routes Block
 |--------------------------------------------------------------------------
 |
 |
 */

//Auth
Auth::routes();
Route::get('/logout', [
    'as'   => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);

//Themes

Route::get('/themes', 'ThemeController@index');
Route::get('/themes/new', 'ThemeController@create');
Route::post('/themes/new', 'ThemeController@store');
Route::get('/themes/{id}/edit', 'ThemeController@edit');
Route::get('/themes/{id}/delete', 'ThemeController@delete');
Route::get('/themes/{id}/destroy', 'ThemeController@destroy');
Route::post('/themes/{id}/edit', 'ThemeController@schemaUpdate');
Route::get('/themes/{id}/active', 'ThemeController@active');




Route::group(['prefix' => 'langs'], function(){

    Route::get('/', [
        'as'   => 'langs',
        'uses' => 'Backend\LangController@index'
    ]);

    Route::post('/new', [
        'as'   => 'langs.new',
        'uses' => 'Backend\LangController@create'
    ]);

    Route::post('/edit', [
        'as'   => 'langs.edit',
        'uses' => 'Backend\LangController@edit'
    ]);


    Route::post('/store', [
        'as'   => 'langs.store',
        'uses' => 'Backend\LangController@store'
    ]);

    Route::post('/update', [
        'as'   => 'langs.update',
        'uses' => 'Backend\LangController@update'
    ]);

    Route::post('/active', [
        'as'   => 'langs.active',
        'uses' => 'Backend\LangController@active'
    ]);

});

Route::get('/documentation', [
    'as'   => 'documentation',
    'uses' => 'Backend\DocumentationController@index'
]);


/*
 |--------------------------------------------------------------------------
 |  Front end Routes Block
 |--------------------------------------------------------------------------
 |
 | Within this block, the front-end routes are registered.
 |
 |
 */

Route::get('/',  [
    'as'   => 'front.home',
    'uses' => 'HomeController@index'
]);

/*Sharing variables to the view*/
View::composer(
    ['front.project', 'front.project-info','front.home','front.contact','layouts/front'],
    'App\Http\ViewComposers\FrontEndProjectComposer'
);

Route::get('/project/{id}/{slug?}',  [
    'as'   => 'front.project',
    'uses' => 'Frontend\ProjectController@project'
]);

Route::get('/project/{id}/pdf',  [
    'as'   => 'front.project.pdf',
    'uses' => 'Frontend\ProjectController@printPDF'
]);



Route::get('/contact',  [
    'as'   => 'front.contact',
    'uses' => 'ContactController@contact'
]);

Route::post('/contact/send',  [
    'as'   => 'contact.send',
    'uses' => 'ContactController@send'
]);

Route::post('/contact/sendOnlineRequest',  [
    'as'   => 'onlineRequest.send',
    'uses' => 'ContactController@sendOnlineRequest'
]);


Route::group(['prefix' => 'announcements'], function(){

    Route::get('/', [
        'as'   => 'frontend.announcements',
        'uses' => 'Frontend\GlobalAnnouncementsController@index'
    ]);

    Route::get('/{slug}', [
        'as'   => 'frontend.announcement-single',
        'uses' => 'Frontend\GlobalAnnouncementsController@single'
    ]);

});

Route::group(['prefix' => 'sections'], function(){

    Route::get('/', [
       'as' => 'sectionstodisclose.index',
        'uses' => 'Backend\SectionsToDiscloseController@index'
    ]);

    Route::post('update', [
        'as' => 'sectionstodisclose.update',
        'uses' => 'Backend\SectionsToDiscloseController@update'
    ]);

});

Route::group(['prefix' => 'communications-management'], function(){

    Route::get('/', [
        'as'   => 'newsletter',
        'uses' => 'Backend\NewsletterController@index'
    ]);

    Route::post('send', [
        'as'   => 'newsletter.send',
        'uses' => 'Backend\NewsletterController@send'
    ]);

    Route::delete('delete', [
        'as'   => 'newsletter.delete',
        'uses' => 'Backend\NewsletterController@delete'
    ]);

    Route::post('deleteMultiple', [
        'as'   => 'newsletter.deleteMultiple',
        'uses' => 'Backend\NewsletterController@deleteMultiple'
    ]);

    Route::post('subscribe', [
        'as'   => 'newsletter.subscribe',
        'uses' => 'NewsletterController@subscribe'
    ]);

    Route::get('activate/{token}', [
        'as'   => 'newsletter.activate',
        'uses' => 'NewsletterController@activate'
    ]);

    Route::get('unsubscribe/{email}/{token}', [
        'as'   => 'newsletter.unsubscribe',
        'uses' => 'NewsletterController@unsubscribe'
    ]);

    Route::post('unsubscribe/email', [
        'as'   => 'newsletter.unsubscribe_email',
        'uses' => 'NewsletterController@unsubscribe_email'
    ]);

    // /*
    //  * Data-tables routes
    //  */
    Route::post('table', [
        'as'   => 'newsletter.table',
        'uses' => 'Backend\NewsletterController@table'
    ]);

});
Route::get('project-info/{environment}/{type}', [
        'as'   => 'front.project-info',
        'uses' => 'HomeController@projectInfo'
    ]);


/*
 * Data-tables routes
 */

Route::post('/home/tableProjects', [
    'as'   => 'front.tableProjects',
    'uses' => 'HomeController@table'
]);

/**
 * API Routes
 * ========================================
 * -> Name: Api homepage.
 * -> Route: ("/").
 * -> Description: Main route of the API.
 * -> Return: Basic status availability of the API.
 * -> Format: JSON.
 * ----------------------------------------
 * -> Name: Api online status.
 * -> Route: ("/check/status/")
 * -> Description: Check if the API is accessible or not.
 * -> Format: JSON.
 * ----------------------------------------
 *
 */

Route::group(['prefix' => 'api'], function() {

    Route::get('/', [
        'as' => 'api.status',
        'uses' => 'ApiControllerV2@status'
    ]);

    Route::get('/projects', [
        'as' => 'api.projects',
        'uses' => 'ApiControllerV2@projects'
    ]);

    Route::get('/project', [
        'as' => 'api.project',
        'uses' => 'ApiControllerV2@project'
    ]);

    Route::get('/project/{ocid}/{args?}', [
        'as' => 'api.project',
        'uses' => 'ApiControllerV2@project'
    ]);

    Route::get('/documentation', [
        'as' => 'api.documentation',
        'uses' => 'ApiControllerV2@documentation'
    ]);

    Route::get('/bulk', [
        'as' => 'api.bulk',
        'uses' => 'ApiControllerV2@bulk'
    ]);

    // Route::get('/check/status', [
    //     'as' => 'check_ApiStatus',
    //     'uses' => 'ApiWrapper@check_ApiStatus'
    // ]);
    //
    // Route::get('/check/version/list', [
    //     'as' => 'check_ApiVersionList',
    //     'uses' => 'ApiWrapper@check_ApiVersionList'
    // ]);
    //
    // Route::get('/check/version/latest', [
    //     'as' => 'check_ApiVersionLatest',
    //     'uses' => 'ApiWrapper@check_ApiVersionLatest'
    // ]);
    //
    // Route::get('/check/publisher', [
    //     'as' => 'get_Publisher_Data',
    //     'uses' => 'ApiWrapper@get_Publisher_Data'
    // ]);
    //
    // Route::get('/documentation', [
    //     'as' => 'get_Api_Documentation',
    //     'uses' => 'ApiWrapper@get_ApiDocumentation'
    // ]);
    //
    // Route::group(['prefix' => '/{version?}'], function() {
    //
    //     Route::get('/', [
    //         'as' => 'api_loader',
    //         'uses' => 'ApiWrapper@loader'
    //     ]);
    //
        // Route::get('/project/all', [
        //     'as' => 'get_Project_All_Data',
        //     'uses' => 'ApiWrapper@get_Project_All_Data'
        // ]);
        //
        // Route::get('/project/{ocid}/{args?}', [
        //     'as' => 'get_Project_Data',
        //     'uses' => 'ApiWrapper@get_Project_Data'
        // ]);
    //
    // });

});

/*
 |--------------------------------------------------------------------------
 |  End Front End Routes Block
 |--------------------------------------------------------------------------
 |
 |
 */
Route::get('/newsletterconfirmation',  [
    'as'   => 'front.newsletter-confirmation',
    'uses' => 'HomeController@newsletterconfirm'
]);
