<?php

$this->group(['middleware' => 'auth'], function () {
    $this->get('/', 'IndexController@index')->name('index');
    $this->get('/search', 'IndexController@search')->name('search');
});

//管理员才可以操作
$this->group(['middleware' => 'admin'], function () {
    //记录相关
    $this->get('add', 'IndexController@addView')->name('add');
    $this->post('add', 'IndexController@post');
    $this->get('update/{id}', 'IndexController@updateView')->name('update');
    $this->post('update/{id}', 'IndexController@post');
    $this->get('destroy/{id}', 'IndexController@destroy')->name('destroy');

    //会员相关
    $this->get('/user/list/', 'UserController@listView')->name('user_list');
    $this->get('/user/list/{keyword}', 'UserController@listView')->name('user_search');
    $this->get('/user/add', 'UserController@addView')->name('user_add');
    $this->post('/user/add', 'UserController@post');
    $this->get('/user/update/{id}', 'UserController@updateView')->name('user_update');
    $this->post('/user/update/{id}', 'UserController@post');
    $this->get('/user/destroy/{id}', 'UserController@destroy')->name('user_destroy');
});

//登录退出
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('login');
$this->get('logout', 'Auth\LoginController@logout')->name('logout');