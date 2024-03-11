<?php

use App\Http\Controllers\API\RESTful\V1\Auths\AuthController;
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
//Route::apiResource('apiRoles', 'App\Http\Controllers\RoleController');

Route::namespace("App\Http\Controllers\API\RESTful")->middleware([])->group(function () {

    // public routes
    ///Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');

    Route::group(['namespace' => 'V1', 'as' => 'v1.'], function () {
        // Login
        Route::post('login', 'Auths\LoginController');


        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

        Route::get('/user', 'Auths\AuthController@user')
            ->middleware('auth:api');

    });

    Route::middleware([/* 'auth:api' */])->group(function () {
        Route::group(['namespace' => 'V1', 'as' => 'v1.'], function () {

            /*
            |--------------------------------------------------------------------------
            | User Routes
            |--------------------------------------------------------------------------
            |
            | This group contains the API resource routes for the 'users' module.
            | These routes are handled by the 'UserController' controller.
            | The route parameter 'users' is aliased as 'id_user'.
            |
            */

            /*
            |--------------------------------------------------------------------------
            | Permission Routes
            |--------------------------------------------------------------------------
            |
            | This group contains the API resource routes for the 'users' module.
            | These routes are handled by the 'PermissionController' controller.
            | The route parameter 'users' is aliased as 'id_user'.
            |
            */
            // Routes for 'permissions' resource
            Route::group(['as' => 'permissions.'], function () {

                // Get all permissions
                Route::get('/permissions', 'PermissionController');
            });


            /*
            |--------------------------------------------------------------------------
            | Role Routes
            |--------------------------------------------------------------------------
            |
            | This group contains the API resource routes for the 'roles' module.
            | These routes are handled by the 'RoleController' controller.
            | The route parameter 'users' is aliased as 'id_user'.
            |
            */
            Route::group([], function () {

                Route::apiResource('roles', 'RoleController')->parameters(['roles' => 'role_id']);

                Route::group(['prefix'=> 'roles'], function () {
                    // Get all roles
                    Route::put('{role_id}/grant-access', 'RoleController@grantAccess')->name('roles.grantAccess');
                    Route::put('{role_id}/revoke-access', 'RoleController@revokeAccess')->name('roles.revokeAccess');
                    Route::get('{role_id}/access', 'RoleController@fetchRoleAccess')->name('roles.fetchRoleAccess');
                });
            });


            /*
            |--------------------------------------------------------------------------
            | User Routes
            |--------------------------------------------------------------------------
            |
            | This group contains the API resource routes for the 'users' module.
            | These routes are handled by the 'UserController' controller.
            | The route parameter 'users' is aliased as 'id_user'.
            |
            */
            Route::group([], function () {

                Route::apiResource('users', 'UserController')->parameters(['users' => 'user_id']);


                Route::group(['prefix'=> 'users'], function () {
                    // Get user privileges
                    Route::put('{user_id}/assign-roles', 'UserController@assignRolePrivileges')->name('users.assignRolePrivileges');
                    Route::put('{user_id}/revoke-roles', 'UserController@revokeRolePrivileges')->name('users.revokeRolePrivileges');
                    Route::get('{user_id}/roles', 'UserController@fetchUserRoles')->name('users.fetchUserRoles');
                });


                // User Status Management
                /* Route::group([], function () {

                        Route::put('/{user}/activate',    'AccountController@activateAccount')->name('users.activateAccount');
                        Route::put('/{user}/deactivate',  'AccountController@deactivateAccount')->name('users.activateAccount');
                        Route::put('/{user}/suspend',     'AccountController@suspendAccount')->name('users.suspendAccount');
                        Route::put('/{user}/unsuspend',   'AccountController@unsuspendAccount')->name('users.unsuspendAccountr');
                });

                Route::group(['prefix'=> ''], function () {
                    Route::get('/{user}/profile', 'ProfileController@profile')->name('profile');
                    Route::put('/{user}/change-password', 'ProfileController@changePassword')->name('profile.changePassword');

                }); */
            });




            /*
            |--------------------------------------------------------------------------
            | Departement Routes
            |--------------------------------------------------------------------------
            |
            | This group contains the API resource routes for the 'departements' module.
            | These routes are handled by the 'DepartementController' controller.
            | The route parameter 'users' is aliased as 'id_user'.
            |
            */
            Route::group([], function () {

                Route::apiResource('departements', 'DepartementController')->parameters(['departements' => 'departement_id']);

                Route::apiResource('postes', 'PosteController')->parameters(['postes' => 'poste_id']);

                Route::group(['prefix'=> 'postes'], function () {
                    Route::put('{poste_id}/attach-salaries', 'PosteController@attachSalariesToAPoste')->name('postes.attach');
                    Route::delete('{poste_id}/detach-salaries', 'PosteController@detachSalariesFromAPoste')->name('postes.detach');
                    Route::get('{poste_id}/salaries', 'PosteController@fetchPosteSalaries')->name('postes.salaries');
                });

                Route::apiResource('unite_mesures', 'UniteMesureController')->parameters(['unite_mesures' => 'unite_mesure_id']);

                Route::apiResource('unite_travailles', 'UniteTravailleController')->parameters(['unite_travailles' => 'unite_travaille_id']);

                Route::group(['prefix'=> 'unite_travailles'], function () {
                    Route::put('{unite_travaille_id}/add-taux', 'UniteTravailleController@addTaux')->name('unite_travailles.addTaux');
                    Route::patch('{unite_travaille_id}/edit-taux', 'UniteTravailleController@editTaux')->name('unite_travailles.editTaux');
                    Route::delete('{unite_travaille_id}/remove-taux', 'UniteTravailleController@removeTaux')->name('unite_travailles.removeTaux');
                });

                Route::apiResource('categories_of_employees', 'CategoryOfEmployeeController')->parameters(['categories_of_employees' => 'category_of_employee_id']);

                Route::group(['prefix'=> 'categories_of_employees'], function () {
                    Route::put('{category_of_employee_id}/attach-taux', 'CategoryOfEmployeeController@attachTauxToACategoryOfEmployee')->name('categories_of_employees.attach');
                    Route::delete('{category_of_employee_id}/detach-taux', 'CategoryOfEmployeeController@detachTauxFromACategoryOfEmployee')->name('categories_of_employees.detach');
                    Route::get('{category_of_employee_id}/taux', 'CategoryOfEmployeeController@fetchCategoryOfEmployeeTaux')->name('categories_of_employees.taux');
                });

                Route::apiResource('employees', 'CategoryOfEmployeeController')->parameters([
                    'employees' => 'employee_id'
                ]);;

            });

        });
    });
});

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
