<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'api'], function () use ($router) {
    //lender request
    $router->get('loans/lender',  ['uses' => 'LoanController@showAllLoansRequestOfLender']);
    $router->post('loans/lender/{id}',  ['uses' => 'LoanController@createLoanRequestOfLender']);
    $router->delete('loans/lender/{id}',  ['uses' => 'LoanController@deleteLoanRequestOfLender']);

    //users: borrowers, lenders
    $router->get('users/borrowers',  ['uses' => 'UsersController@showBorrowers']);
    $router->get('users/lenders',  ['uses' => 'UsersController@showLenders']);
    $router->get('users/borrowers/{id}',  ['uses' => 'UsersController@showOneBorrower']);
    $router->get('users/lenders/{id}',  ['uses' => 'UsersController@showOneLender']);
    $router->post('users/borrowers',  ['uses' => 'UsersController@createBorrower']);
    $router->post('users/lenders',  ['uses' => 'UsersController@createLender']);
    $router->delete('users/borrowers/{id}',  ['uses' => 'UsersController@deleteBorrower']);
    $router->delete('users/lenders/{id}',  ['uses' => 'UsersController@deleteLender']);
    $router->put('users/borrowers/{id}',  ['uses' => 'UsersController@updateBorrower']);
    $router->put('users/lenders/{id}',  ['uses' => 'UsersController@updateLender']);

    //address
    $router->get('users/address',  ['uses' => 'UsersController@showAllAddress']);
    $router->post('users/address',  ['uses' => 'UsersController@createAddress']);

    //loans
    $router->get('loans',  ['uses' => 'LoanController@showAllLoansRequest']);
    $router->get('loans/{id}',  ['uses' => 'LoanController@showALoansRequest']);
    $router->post('loans',  ['uses' => 'LoanController@createLoansRequest']);
    $router->delete('loans/{id}',  ['uses' => 'LoanController@deleteLoansRequest']);
    $router->put('loans/{id}',  ['uses' => 'LoanController@updateLoansRequest']);

    //action of lenders to allow/accept loan request
    $router->post('loans/final/{id}',  ['uses' => 'LoanController@finalLoan']);
});
