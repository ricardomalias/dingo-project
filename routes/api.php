<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
    });

    $api->group(['prefix' => 'user'], function (Router $api) {
        $api->get('/me', 'App\\feature\\user\\controllers\\UserController@me');
        $api->get('/{id}', 'App\\feature\\user\\controllers\\UserController@getUser');
        $api->post('/company/{company_id}', 'App\\feature\\user\\controllers\\UserController@saveUser');
    });

    $api->group(['prefix' => 'company'], function(Router $api) {
        $api->post('/', 'App\\feature\\company\\controller\\CompanyController@saveCompany');
        $api->get('/', 'App\\feature\\company\\controller\\CompanyController@getCompanies');
        $api->get('/{company_id}', 'App\\feature\\company\\controller\\CompanyController@getCompany');
        $api->put('/{company_id}', 'App\\feature\\company\\controller\\CompanyController@editCompany');
        $api->delete('/{company_id}', 'App\\feature\\company\\controller\\CompanyController@deleteCompany');

        $api->group(['prefix' => '/configuration'], function(Router $api) {
            $api->get('/common', 'App\\feature\\company\\controller\\CompanyConfigurationController@getCompanyConfigurationCommon');
        });

        $api->group(['prefix' => '{company_id}/configuration'], function(Router $api) {
            $api->get('/', 'App\\feature\\company\\controller\\CompanyConfigurationController@getCompanyConfigurations');
            $api->put('/', 'App\\feature\\company\\controller\\CompanyConfigurationController@editCompanyConfiguration');
        });
    });

    $api->group(['prefix' => 'customer'], function(Router $api) {
        $api->post('/', 'App\\feature\\customer\\controller\\CustomerController@saveCustomer');
//        $api->get('/', 'App\\feature\\customer\\controller\\CustomerController@getCustomers');
        $api->get('/{customer_id}', 'App\\feature\\customer\\controller\\CustomerController@getCustomer');
        $api->put('/{customer_id}', 'App\\feature\\customer\\controller\\CustomerController@editCustomer');
        $api->delete('/{customer_id}', 'App\\feature\\customer\\controller\\CustomerController@deleteCustomer');

        $api->group(['prefix' => 'company'], function(Router $api) {
            $api->get('/{company_id}', 'App\\feature\\customer\\controller\\CustomerController@getCustomers');
            $api->get('/{company_id}/search/{query}', 'App\\feature\\customer\\controller\\CustomerController@getCustomerSearch');
            $api->get('/{company_id}/list', 'App\\feature\\CustomerList\\controller\\CustomerListController@getCustomerLists');
            $api->get('/{company_id}/list/{customer_list_id}', 'App\\feature\\CustomerList\\controller\\CustomerListController@getCustomerList');
            $api->post('/{company_id}/list', 'App\\feature\\CustomerList\\controller\\CustomerListController@saveCustomerList');
        });
    });

    $api->group(['prefix' => 'debt'], function(Router $api) {
        $api->post('/', 'App\\feature\\debt\\controller\\DebtController@saveDebt');
        $api->get('/customer/{customer_id}', 'App\\feature\\debt\\controller\\DebtController@getCustomerDebts');
        $api->get('/company/{company_id}', 'App\\feature\\debt\\controller\\DebtController@getCompanyDebts');
        $api->get('/{debt_id}', 'App\\feature\\debt\\controller\\DebtController@getDebt');
        $api->put('/{debt_id}', 'App\\feature\\debt\\controller\\DebtController@editDebt');
        $api->delete('/{debt_id}', 'App\\feature\\debt\\controller\\DebtController@deleteDebt');
    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('public/debt/{debt_id}','App\\feature\\debt\\controller\\DebtPublicController@getDebt');

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
