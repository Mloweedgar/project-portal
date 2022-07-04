<?php

// Home
Breadcrumbs::register('dashboard', function($breadcrumbs)
{
    $breadcrumbs->push(__('menu.dashboard'), route('dashboard'));
});

// PROJECT
Breadcrumbs::register('project', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(__('menu.projects'), route('add-project'));
});

Breadcrumbs::register('edit-users', function($breadcrumbs)
{
    $breadcrumbs->push(__('menu.edit-users'), route('edit-users'));
});
Breadcrumbs::register('users.deleted', function($breadcrumbs)
{
    $breadcrumbs->push(__('menu.deleted_users'), route('users.deleted'));
});

Breadcrumbs::register('documentation', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.documentation'), route('documentation'));
});

Breadcrumbs::register('analytics.dashboard', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.analytics'), route('analytics.dashboard'));
});

/**
 * Roles man
 */
Breadcrumbs::register('roles.roles-permissions', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.roles-permissions'), route('roles.roles-permissions'));
});


// Home > [Add-Project]
Breadcrumbs::register('add-project', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.projects'), route('add-project'));
});

Breadcrumbs::register('import-project', function($breadcrumbs)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("add-project.import_project"), route('import-project'));
});


// Website Management
Breadcrumbs::register('website-management', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.website-management'), route('sliders'));
});

Breadcrumbs::register('sliders', function($breadcrumbs)
{
    $breadcrumbs->parent('website-management');
    $breadcrumbs->push(trans('menu.sliders'), route('sliders'));
});


Breadcrumbs::register('banners', function($breadcrumbs)
{
    $breadcrumbs->parent('website-management');
    $breadcrumbs->push(trans('menu.banners'), route('banners'));
});

Breadcrumbs::register('graphs', function($breadcrumbs)
{
    $breadcrumbs->parent('website-management');
    $breadcrumbs->push(trans('menu.graphs'), route('graphs'));
});

Breadcrumbs::register('footer', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.footer'), route('footer'));
});

Breadcrumbs::register('admin.global-announcements', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.global-announcements'), route('admin.global-announcements'));
});

Breadcrumbs::register('admin.global-announcements-new', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.global-announcements');
    $breadcrumbs->push(trans('global-announcements.announcement'), route('admin.global-announcements-new'));
});

Breadcrumbs::register('admin.global-announcements-edit', function($breadcrumbs,$id)
{
    $breadcrumbs->parent('admin.global-announcements');
    $breadcrumbs->push(trans('global-announcements.announcement'), route('admin.global-announcements-edit',$id));
});


Breadcrumbs::register('general-settings', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.general-settings'), route('general-settings'));
});

Breadcrumbs::register('activity_log', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.activity_log'), route('activity_log'));
});


Breadcrumbs::register('tasks-management', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(__('task.header'), route('tasks-management'));
});

Breadcrumbs::register('entities', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(__('menu.entities'), route('entities'));
});

Breadcrumbs::register('langs', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(__('menu.langs'), route('langs'));
});

/*
|--------------------------------------------------------------------------
|  USER ROUTES BLOCK
|--------------------------------------------------------------------------
*/

Breadcrumbs::register('account', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.account'), route('account'));
});

Breadcrumbs::register('change-password', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.change-password'), route('change-password'));
});

/*
|--------------------------------------------------------------------------
|  END USER ROUTES BLOCK
|--------------------------------------------------------------------------
*/


Breadcrumbs::register('project.project-information', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');

    $breadcrumbs->push(trans("project.section.project_basic_information"), route('project.project-information', $id));
});


Breadcrumbs::register('project.parties', function($breadcrumbs,$id)
{
    $breadcrumbs->parent('add-project');

    $breadcrumbs->push(trans("project.section.parties"), route('project.parties',$id));
});

Breadcrumbs::register('project.gallery', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.gallery"), route('project.gallery', $id));
});


Breadcrumbs::register('project.contract-milestones', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.contract_milestones"), route('project.contract-milestones', $id));
});

Breadcrumbs::register('project-details-documents', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.documents"), route('project-details-documents', $id));
});

Breadcrumbs::register('project-details-environment', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.environment"), route('project-details-environment', $id));
});

Breadcrumbs::register('project-details-announcements', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.announcements"), route('project-details-announcements', $id));
});

Breadcrumbs::register('project.procurement', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.procurement"), route('project.procurement', $id));
});

Breadcrumbs::register('project-details-risks', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.risks"), route('project-details-risks', $id));
});

Breadcrumbs::register('project-details-evaluation-ppp', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.evaluation-ppp"), route('project-details-evaluation-ppp', $id));
});

Breadcrumbs::register('project-details-financial', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.financial"), route('project-details-financial', $id));
});

Breadcrumbs::register('project-details-government-support', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.government-support"), route('project-details-government-support', $id));
});

Breadcrumbs::register('project-details-tariffs', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.tariffs"), route('project-details-tariffs', $id));
});

Breadcrumbs::register('project-details-contract-termination', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.contract-termination"), route('project-details-contract-termination', $id));
});

Breadcrumbs::register('project-details-contract-summary', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.contract-summary"), route('project-details-contract-summary', $id));
});

Breadcrumbs::register('project-details-renegotiations', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.renegotiations"), route('project-details-renegotiations', $id));
});

Breadcrumbs::register('project-details-award', function($breadcrumbs, $id)
{
    $breadcrumbs->parent('add-project');
    $breadcrumbs->push(trans("project.section.project_details.award"), route('project-details-award', $id));
});


/*
 * PERFORMANCE INFORMATION
 */

/*
|--------------------------------------------------------------------------
|  PERFORMANCE ROUTES BLOCK
|--------------------------------------------------------------------------
*/
/*Breadcrumbs::register('project.performance-information.other-financial-metrics', function($breadcrumbs, $id) {

    $breadcrumbs->parent('project');
    //TODO Add performance information as parent
    $breadcrumbs->push('Actual Internal Rate of Return', route('project.performance-information.other-financial-metrics',$id));
});
*/
Breadcrumbs::register('project.performance-information.annual-demand-levels', function($breadcrumbs, $id) {

    $breadcrumbs->parent('project');
    //TODO Add performance information as parent
    $breadcrumbs->push(trans("project.section.performance_information.annual_demand_levels"), route('project.performance-information.annual-demand-levels',$id));
});

Breadcrumbs::register('project.performance-information.income-statements-metrics', function($breadcrumbs, $id) {

    $breadcrumbs->parent('project');
    //TODO Add performance information as parent
    $breadcrumbs->push(trans("project.section.performance_information.income_statements_metrics"), route('project.performance-information.income-statements-metrics',$id));
});

Breadcrumbs::register('project.performance-information.other-financial-metrics', function($breadcrumbs, $id) {

    $breadcrumbs->parent('project');
    //TODO Add performance information as parent
    $breadcrumbs->push(trans("project.section.performance_information.other_financial_metrics"), route('project.performance-information.other-financial-metrics',$id));
});

Breadcrumbs::register('project.performance-information.key-performance-indicators', function($breadcrumbs, $id) {

    $breadcrumbs->parent('project');
    //TODO Add performance information as parent
    $breadcrumbs->push(trans("project.section.performance_information.key_performance_indicators"), route('project.performance-information.key-performance-indicators',$id));
});

Breadcrumbs::register('project.performance-information.performance-failures', function($breadcrumbs, $id) {

    $breadcrumbs->parent('project');
    //TODO Add performance information as parent
    $breadcrumbs->push(trans("project.section.performance_information.performance_failures"), route('project.performance-information.performance-failures',$id));
});

Breadcrumbs::register('project.performance-information.performance-assessments', function($breadcrumbs, $id) {

    $breadcrumbs->parent('project');
    //TODO Add performance information as parent
    $breadcrumbs->push(trans("project.section.performance_information.performance-assessments"), route('project.performance-information.performance-assessments',$id));
});




/*
|--------------------------------------------------------------------------
|  END PERFORMANCE ROUTES
|--------------------------------------------------------------------------
*/

// Newsletter, Communication Management
Breadcrumbs::register('newsletter', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.communications-management'), route('newsletter'));
});

// Sections to Disclose
Breadcrumbs::register('sectionstodisclose.index', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('menu.fields-disclose'), route('sectionstodisclose.index'));
});
