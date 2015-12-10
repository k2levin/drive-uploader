<?php

// home
get('/',     ['as' => 'home',  'uses' => 'HomeController@index']);
get('about', ['as' => 'about', 'uses' => 'HomeController@about']);

// drive
get('list_files',               ['as' => 'list_files',        'uses' => 'DriveController@listFiles']);
get('list_files/{folder_id}',   ['as' => 'list_files.folder', 'uses' => 'DriveController@listFiles']);
get('upload/{folder_id}',       ['as' => 'upload',            'uses' => 'DriveController@upload']);
post('upload/{folder_id}',      ['as' => 'post.upload',       'uses' => 'DriveController@postUpload']);
get('enable_public/{file_id}',  ['as' => 'enable_public',     'uses' => 'DriveController@enablePublic']);
get('disable_public/{file_id}', ['as' => 'disable_public',    'uses' => 'DriveController@disablePublic']);
get('delete/{file_id}',         ['as' => 'delete',            'uses' => 'DriveController@delete']);

// get refresh token
get('generate_token', ['as' => 'generate_token', 'uses' => 'TokenController@generateToken']);
get('get_token',      ['as' => 'get_token',      'uses' => 'TokenController@getToken']);
