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

                Route::group(['prefix' => 'roles'], function () {
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


                Route::group(['prefix' => 'users'], function () {
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

                Route::group(['prefix' => 'postes'], function () {
                    Route::put('{poste_id}/attach-salaries', 'PosteController@attachSalariesToAPoste')->name('postes.attach');
                    Route::delete('{poste_id}/detach-salaries', 'PosteController@detachSalariesFromAPoste')->name('postes.detach');
                    Route::get('{poste_id}/salaries', 'PosteController@fetchPosteSalaries')->name('postes.salaries');
                });

                Route::apiResource('unite_mesures', 'UniteMesureController')->parameters(['unite_mesures' => 'unite_mesure_id']);

                Route::apiResource('unite_travailles', 'UniteTravailleController')->parameters(['unite_travailles' => 'unite_travaille_id']);

                Route::group(['prefix' => 'unite_travailles'], function () {
                    Route::put('{unite_travaille_id}/add-taux', 'UniteTravailleController@addTaux')->name('unite_travailles.addTaux');
                    Route::patch('{unite_travaille_id}/edit-taux', 'UniteTravailleController@editTaux')->name('unite_travailles.editTaux');
                    Route::delete('{unite_travaille_id}/remove-taux', 'UniteTravailleController@removeTaux')->name('unite_travailles.removeTaux');
                });

                Route::apiResource('categories_of_employees', 'CategoryOfEmployeeController')->parameters(['categories_of_employees' => 'category_of_employee_id']);

                Route::group(['prefix' => 'categories_of_employees'], function () {
                    Route::put('{category_of_employee_id}/attach-taux', 'CategoryOfEmployeeController@attachTauxToACategoryOfEmployee')->name('categories_of_employees.attach');
                    Route::delete('{category_of_employee_id}/detach-taux', 'CategoryOfEmployeeController@detachTauxFromACategoryOfEmployee')->name('categories_of_employees.detach');
                    Route::get('{category_of_employee_id}/taux', 'CategoryOfEmployeeController@fetchCategoryOfEmployeeTaux')->name('categories_of_employees.taux');
                });

                Route::apiResource('employees', 'EmployeeController')->parameters([
                    'employees' => 'employee_id' //
                ]);


                /* 
                Route::group(['prefix'=>'employees'],function(){
                    Route::put('{employee_id}/chaging_type', 'EmployeeController@changing_type_employee')->name('changing_type');
                }); */

                Route::apiResource('partners', 'PartnerController')->parameters([
                    'partners' => 'partner_id' //
                ]);

                Route::group(['prefix' => 'employeecontractuels'], function () {

                    Route::post('/new-post', 'EmployeeContractuelController@assignmentOfPost')->name('employeecontractuels.assignmentOfPost');

                    Route::get('{contract_id}/{employee_contractuel_id}/terminate-contract', 'EmployeeContractuelController@terminateContract')->name('employeecontractuels.terminateContract');
                });

                Route::group(['prefix' => 'employeenoncontractuels'], function () {

                    Route::put('{employee_non_contractuel_id}/{category_employee_id}/new-category', 'EmployeeNonContractuelController@changeCategoryOfNonContractualEmployee')->name('employeenoncontractuels.changeCategoryOfNonContractualEmployee');
                });

                Route::apiResource('contracts', 'ContractController')->parameters([
                    'contracts' => 'contract_id' //
                ]);


                /*Route::apiResource('employees', 'CategoryOfEmployeeController'); */

                Route::group(['namespace' => 'Finances'], function () {


                    Route::apiResource('devises', 'DeviseController')->parameters(['devises' => 'devise_id']);

                    Route::apiResource('categories_de_compte', 'CategorieDeCompteController')->parameters(['categories_de_compte' => 'categorie_de_compte_id']);

                    Route::apiResource('classes_de_compte', 'ClasseDeCompteController')->parameters(['classes_de_compte' => 'classe_de_compte_id']);

                    Route::apiResource('comptes', 'CompteController')->parameters(['comptes' => 'compte_id']);

                    Route::apiResource('journaux', 'JournalController')->parameters(['journaux' => 'journal_id']);

                    Route::apiResource('periodes_exercice', 'PeriodeExerciceController')->parameters(['periodes_exercice' => 'periode_exercice_id']);

                    Route::apiResource('plans_comptable', 'PlanComptableController')->parameters(['plans_comptable' => 'plan_comptable_id']);

                    Route::group(['prefix' => 'plans_comptable'], function () {
                        Route::put('{plan_comptable_id}/attach-accounts', 'PlanComptableController@addNewAccountsToPlan')->name('plans_comptable.attach');
                        Route::patch('{plan_comptable_id}/update-attach-accounts', 'PlanComptableController@updateAccountsInPlan')->name('plans_comptable.update-attach');
                        Route::patch('{plan_comptable_id}/detach-accounts', 'PlanComptableController@deleteAccountsFromPlan')->name('plans_comptable.detach');
                        Route::get('{plan_comptable_id}/accounts', 'PlanComptableController@fetchAccounts')->name('plans_comptable.accounts');
                        Route::get('{plan_comptable_id}/valider', 'PlanComptableController@validatePlanComptable')->name('plans_comptable.valider');
                    });

                    Route::group(['prefix' => 'plans_comptable'], function () {
                        Route::put('{plan_comptable_id}/accounts/{account_id}/attach-sub-accounts-to-an-account', 'PlanComptableController@addNewSubAccountsToAPlanAccount')->name('plans_comptable.account.attach');
                        Route::patch('{plan_comptable_id}/accounts/{account_id}/update-attach-sub-accounts-of-an-account', 'PlanComptableController@updateSubAccountsInPlanAccount')->name('plans_comptable.account.update-attach');
                        Route::patch('{plan_comptable_id}/accounts/{account_id}/detach-sub-accounts-from-an-account', 'PlanComptableController@deleteSubAccountsFromAPlanAccount')->name('plans_comptable.account.detach');
                        Route::get('{plan_comptable_id}/accounts/{account_id}/sub-accounts', 'PlanComptableController@fetchSubAccountsOfAPlanAccount')->name('plans_comptable.account.sub-accounts');
                    });

                    Route::apiResource('exercices_comptable', 'ExerciceComptableController')->parameters(['exercices_comptable' => 'exercice_comptable_id']);
                });
                
                Route::group(['namespace' => 'Magasins'], function () {

                    Route::apiResource('magasins', 'MagasinController')->parameters(['magasins' => 'magasin_id']);

                    Route::apiResource('storagespaces', 'StorageSpaceController')->parameters(['storagespaces' => 'storage_space_id']);

                });

                Route::group(['namespace' => 'Articles'], function () {                
                    Route::apiResource('articles', 'ArticleController')->parameters([
                        'articles' => 'article_id'
                    ]);
    
                    Route::apiResource('categorie_articles', 'CategorieArticleController')->parameters([
                        'categorie_articles' => 'categorie_article_id'
                    ]);

                });

            });
        });
    });
});

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    Route::get('resource/{first_id}/{second_id}', function($first_id, $second_id){
                    return [$first_id, $second_id];
                })
}); */
