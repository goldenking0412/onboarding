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

Route::get('/', 'WelcomeController@show');

Route::group(['middleware' => ['auth']], function (){

    Route::get('/home', 'HomeController@home')->name('customer.dashboard');
    // Route::post('{user}/assets-link', 'HomeController@submitAssetURL')->name('customer.asset-url');

    Route::get('surveys/{survey}/next', 'SurveyController@nextQuestion')->name('surveys.next');
    Route::get('surveys/{survey}/{question}/show', 'SurveyController@showQuestion')->name('surveys.showQuestion');
    Route::get('surveys/{survey}/answer/{question}', 'SurveyController@answerQuestion')->name('surveys.answer');

    Route::post('assets/upload', 'AssetController@uploadAssets')->name('assets.upload');
    Route::post('prototype/upload', 'AssetController@uploadPrototype')->name('prototype.upload');
    Route::post('prototype/post-tracking', 'AssetController@postTracking')->name('prototype.post-tracking');
    Route::post('services/mark-connected', 'QuestionController@markConnected')->name('services.mark-connected');

    Route::group(['prefix' => 'knowledgebase'], function (){
        Route::group(['prefix' => 'category'], function (){
            Route::get('{id}', 'CategoryController@show');
        });
        Route::get('/', 'CategoryController@index')->name('knowledgebase');
        Route::get('{id}', 'ArticleController@show');
    });

    Route::post ( '/search', 'ArticleController@search');

    Route::get('new-conversation', 'TicketsController@create');
    Route::post('new-conversation', 'TicketsController@store')->name('new-conversation');
    Route::get('support/{ticket_id}', 'TicketsController@show');
    Route::get('support', 'TicketsController@userTickets')->name('support');
    Route::post('comment', 'CommentsController@postComment');
    
});



Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function (){
    Route::get('dashboard', 'Admin\MainController@getDashboard')->name('admin.dashboard');
    Route::get('customers/add', 'Admin\CustomerController@addCustomerForm')->name('admin.customer.add');
    Route::post('customers/store', 'Admin\CustomerController@postCustomer')->name('admin.customer.store');
    Route::get('customers/{user}/show', 'Admin\CustomerController@show')->name('admin.customer.show');
    Route::put('customers/{user}/archive', 'Admin\CustomerController@archive')->name('admin.customer.archive');

    Route::get('customer/{user}/review-survey/{survey}', 'Admin\CustomerController@showReviewSurvey')->name('admin.customer.show-review');
    Route::get('customer/{user}/review-survey/{survey}/export', 'Admin\CustomerController@exportReviewSurvey')->name('admin.customer.export');
    Route::post('customer/{user}/review-answer/{answer}','Admin\CustomerController@postReviewAnswer')->name('admin.review-answer');
    Route::post('customer/{user}/review-assets/{answer}','Admin\CustomerController@postAssetsReview')->name('admin.review-assets');
    Route::post('customer/{user}/review-assets','Admin\CustomerController@postEmptyAssetsReview')->name('admin.review-empty-assets');
    Route::post('customer/{user}/review-prototype/{answer}','Admin\CustomerController@postPrototypeReview')->name('admin.review-prototype');
    Route::post('customer/{user}/review-prototype/','Admin\CustomerController@postEmptyPrototypeReview')->name('admin.review-empty-prototype');
    Route::post('customer/{user}/prototype-received/{answer}','Admin\CustomerController@markReceived')->name('admin.prototype-received');
    Route::put('customer/{user}/complete-prototype', 'Admin\CustomerController@completePrototype')->name('admin.complete-prototype');
    Route::post('custom/{user}/service', 'Admin\CustomerController@serviceConnected')->name('service.connected');
    Route::group(['prefix' => 'knowledgebase'], function (){
        Route::group(['prefix' => 'category'], function (){
            Route::get('/new', 'CategoryController@create')->name('new_category');
            Route::post('/new', 'CategoryController@store');
            Route::get('{id}/edit', 'CategoryController@edit');
            Route::post('{id}/edit', 'CategoryController@update');
            Route::delete('{id}/delete', 'CategoryController@destroy');
        });
        Route::get('/new', 'ArticleController@create')->name('new_article');
        Route::post('/new', 'ArticleController@store');
        Route::get('{id}/edit', 'ArticleController@edit');
        Route::post('{id}/edit', 'ArticleController@update');
        Route::delete('{id}/delete', 'ArticleController@destroy');
    });

    Route::get('support', 'TicketsController@index')->name('admin.support');
    Route::post('close_ticket/{ticket_id}', 'TicketsController@close');

    Route::post('customers/{user}/message', 'Admin\CustomerController@message')->name('send.message');
    Route::post('customers/{user}/admin_notes', 'Admin\CustomerController@admin_notes')->name('add.admin_notes');

    // edit survey
    Route::get('survey/{id}', 'SurveyController@editSurvey')->name('admin.editsurvey');
    Route::get('survey-list/{id}', 'SurveyController@editSurveyList')->name('admin.editsurvey');
    Route::post('survey/{id}', 'SurveyController@updateSurvey')->name('admin.editsurvey');
    Route::post('survey/update-all', 'SurveyController@updateSurvey')->name('admin.updatesurvey');

});

Route::get('test', function (){
    $data = collect(\Illuminate\Support\Facades\Storage::cloud()->listContents('/kana', false));

});