<?php

Route::get('/', 'HomeController')->name('index');

Auth::routes();

Route::group(['middleware' => 'auth', 'namespace' => 'Auth', 'as' => 'auth.', 'prefix' => 'dashboard'], function() {
    Route::get('/', 'DashboardController')->name('index');

    Route::resource('user', 'UserController')->except('show');
    Route::get('user/export', 'UserController@export')->name('user.export');

    Route::resource('project', 'ProjectController');

    Route::group(['prefix' => 'project', 'as' => 'project.'], function() {

        Route::group(['prefix' => '{project}/bug', 'as' => 'bug.'], function() {
            Route::get('index', 'BugController@display')->name('index');
            Route::get('add', 'BugController@create')->name('create');
            Route::post('addImage', 'BugController@store')->name('addImage');
            Route::get('/editimage/{id}','BugController@edit')->name('edit');
            Route::put('/updateimage/{id}','BugController@update')->name('update');
            Route::delete('{id}', 'BugController@delete')->name('delete');
        });

        Route::patch('{project}/finish', 'ProjectController@finish')->name('finish');

//        Need to use patch here because we only need to partially update the task instance
        Route::patch('{project}/task/{task}/{user}', 'TaskController@assignUser')->name('assign.user');
        Route::post('task/{task}', 'TaskController@updateStatusTimer')->name('task.updateTimer');
        Route::patch('task/{task}', 'TaskController@finish')->name('task.finish');
        Route::resource('{project?}/task', 'TaskController')->except('show');
        Route::get('task/{task}/edit', 'TaskController@edit')->name('task.edit.custom');

        Route::group(['prefix' => '{project}/document', 'as' => 'document.'], function() {
            Route::get('create', 'DocumentController@create')->name('create');
            Route::post('store', 'DocumentController@store')->name('store');
            Route::get('{file}/stream', 'DocumentController@stream')->name('stream');
            Route::delete('{file}/destroy', 'DocumentController@destroy')->name('destroy');
        });
    });
    Route::get('documents', 'DocumentController@index')->name('document.index');
    Route::get('calendar','TaskController@calendar')->name('calendar');
});
