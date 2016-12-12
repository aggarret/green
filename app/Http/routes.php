<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => 'web'], function () {
    //Home
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/test', 'HomeController@test');

    //Volunteer Registration Routes...
    Route::get('/admin/register',  'AdminAuth\AuthController@showRegistrationForm');
    Route::post('/admin/register', 'AdminAuth\AuthController@postRegister');

    //Volunteer Login Routes...
    Route::get('/admin/login', 'AdminAuth\AuthController@showLoginForm');
    Route::post('/admin/login','AdminAuth\AuthController@login');

    //Volunteer Registration Routes...
    Route::get('/volunteer/register',  'VolunteerAuth\AuthController@showRegistrationForm');
    Route::post('/volunteer/register', 'VolunteerAuth\AuthController@postRegister');

    //Volunteer Login Routes...
    Route::get('/volunteer/login', 'VolunteerAuth\AuthController@showLoginForm');
    Route::post('/volunteer/login','VolunteerAuth\AuthController@login');

    //Organization Registration Routes...
    Route::get('/organization/register',  'OrganizationAuth\AuthController@showRegistrationForm');
    Route::post('/organization/register', 'OrganizationAuth\AuthController@postRegister');

    //Organization Login Routes...
    Route::get('/organization/login', 'OrganizationAuth\AuthController@showLoginForm');
    Route::post('/organization/login','OrganizationAuth\AuthController@login');
    //guest view routes.
    Route::get('/calendarevents/show/{id}', ['as'=>'calendarevents.show', 
                                             'uses'=>'CalendarEventController@guestshow']);
    Route::get('/calendarevents/index', ['as'=>'Calender.index',
                                         'uses'=>'CalendarEventController@guestindex']
    );
    //post controller
    Route::resource('post', 'postcontroller');
    });
        

/*
|--------------------------------------------------------------------------
| Volunteer Middlewear Routes 
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => ['volunteer']], function ()
{
    
    //Volunteer Logout Route...
    Route::get('/volunteer/logout', [
        'uses' => 'VolunteerAuth\AuthController@logout',
        'as' => 'volunteer.logout',
    ]);

    //Volunteer Dashboard Routes...
    //Route::get('/volunteer/dashboard', 'VolunteerController@getdashboard');
    Route::get('/volunteer/dashboard', [
        'uses' => 'VolunteerController@getdashboard',
        'as' => 'volunteer.dashboard',
    ]);

    Route::get('/volunteer/account', [
        'uses' => 'VolunteerController@getAccount',
        'as' => 'volunteer.account.save',
    ]);

    Route::post('/volunteer/account', [
        'uses' => 'VolunteerController@postAccount',
        'as' => 'volunteer.account',
    ]);

    Route::get('/volunteer/userImage/{filename}', [
        'uses' => 'VolunteerController@getUserImage',
        'as' => 'volunteer.account.image'
    ]);

    Route::get('/calendarevents/register/{id}', [
        'as'=>'calendar_events.register',
        'uses'=>'VolunteerController@getEventRegister'
    ]);

    Route::post('/{name}/{id}/photos', [
        'uses'=>'VolunteerController@addPhoto'
    ]);
    /*
    |--------------------------------------------------------------------------
    | Calender Routes  
    |--------------------------------------------------------------------------
    */
    Route::get('/calendarevents/register/{id}', [
        'as'=>'calendar_events.register',
        'uses'=>'VolunteerController@getEventRegister'
    ]);
});



/*
|--------------------------------------------------------------------------
| Organization Middlewear Routes 
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => ['organization']], function () {
    //Organization logout Route...
    Route::get('/organization/logout', [
        'uses' => 'OrganizationAuth\AuthController@logout',
        'as' => 'organization.logout',
    ]);

    //Organization Dashboard Routes...
    //Route::get('/organization/dashboard', 'OrganizationController@getdashboard');
    Route::get('/organization/dashboard', [
        'uses' => 'OrganizationController@getdashboard',
        'as' => 'organization.dashboard',
    ]);

    Route::get('/organization/account', [
        'uses' => 'OrganizationController@getAccount',
        'as' => 'organization.account',
    ]);

    Route::post('/organization/account', [
        'uses' => 'OrganizationController@postAccount',
        'as' => 'organization.account',
    ]);

    Route::get('/organization/userImage/{filename}', [
        'uses' => 'OrganizationController@getUserImage',
        'as' => 'organization.account.image'
    ]);

    Route::get('/organization/payment', [
        'uses' => 'OrganizationController@getPayment',
        'as' => 'organization.account.payment'
    ]);

    Route::post('/organization/payment', [
        'uses' => 'OrganizationController@postPayment',
        'as' => 'organization.account.payment'
    ]);

    Route::get('/organization/test', [
        'uses' => 'OrganizationController@test',
        'as' => 'organization.test'
    ]);

        /*
    |--------------------------------------------------------------------------
    | Calender Routes  
    |--------------------------------------------------------------------------
    */
    Route::resource('calendar_events', 'CalendarEventController');
    Route::get('/calendar', ['uses' => 'SampleController@calendar']);

});


/*
|--------------------------------------------------------------------------
| Admin Middlewear Routes 
|--------------------------------------------------------------------------
|
*/
Route::group(['middleware' => ['admin']], function () {
    //Organization logout Route...
    Route::get('/admin/logout', [
        'uses' => 'AdminAuth\AuthController@logout',
        'as' => 'admin.logout',
    ]);

    //Organization Dashboard Routes...
    //Route::get('/organization/dashboard', 'OrganizationController@getdashboard');
    Route::get('/admin/dashboard', [
        'uses' => 'AdminController@getdashboard',
        'as' => 'admin.dashboard',
    ]);

    Route::get('/admin/panel/volunteers/{id?}/{direction?}', [
        'uses' => 'AdminController@getPanelVolunteers',
        'as' => 'admin.panel.volunteers',
    ]);

    Route::get('/admin/panel/organizations/{id?}/{direction?}', [
        'uses' => 'AdminController@getPanelOrganizations',
        'as' => 'admin.panel.organizations',
    ]);

    Route::get('/admin/panel/events/{id?}/{direction?}', [
        'uses' => 'AdminController@getPanelEvents',
        'as' => 'admin.panel.events',
    ]);

    Route::get('/admin/panel/interests/{id?}/{direction?}', [
        'uses' => 'AdminController@getPanelInterests',
        'as' => 'admin.panel.interests',
    ]);

    Route::get('/admin/panel/categories/{id?}/{direction?}', [
        'uses' => 'AdminController@getPanelCategories',
        'as' => 'admin.panel.categories',
    ]);

    Route::delete('/admin/panel/volunteers/{id}', [
        'uses' => 'AdminController@destroyVolunteer',
        'as' => 'admin.panel.volunteers.destroy',
    ]);

    Route::delete('/admin/panel/organizations/{id}', [
        'uses' => 'AdminController@destroyOrganization',
        'as' => 'admin.panel.organizations.destroy',
    ]);

    Route::delete('/admin/panel/events/{id}', [
        'uses' => 'AdminController@destroyEvent',
        'as' => 'admin.panel.events.destroy',
    ]);

    Route::delete('/admin/panel/interests/{id}', [
        'uses' => 'AdminController@destroyInterest',
        'as' => 'admin.panel.interests.destroy',
    ]);

    Route::post('/admin/panel/interests/', [
        'uses' => 'AdminController@createInterest',
        'as' => 'admin.panel.interests.create',
    ]);

    Route::get('/admin/panel/test/', [
        'uses' => 'AdminController@test',
        'as' => 'admin.panel.interests.test',
    ]);
});






