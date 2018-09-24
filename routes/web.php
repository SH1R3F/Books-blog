<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index')->name('index');
Route::redirect('/home', '/');
/**
* Authentication
*/
// Login
Route::post('/login', 'Auth\LoginController@login');
Route::get('/login', function(){
    return redirect('/#login');
});

// Registering
Route::post('/register', 'Auth\RegisterController@register');
Route::get('/register', function(){
    return redirect('/#register');
});
Route::get('/register/confirm/{token}', 'Auth\RegisterController@confirm_email')->name('email.confirm');

// Logging out
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Resetting password
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');

Route::post('/password/email', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// Admin panel
Route::prefix('/manage')->middleware('role:superadministrator|administrator|author|editor')->group(function(){
  Route::get('/', function(){
      return redirect('/manage/dashboard');
  });
  // Dashboard
  Route::get('/dashboard', 'ManageController@dashboard')->name('dashboard');

  // Books
  Route::get('/books', 'BooksController@index')->name('books');
  Route::get('/book/create', 'BooksController@create')->name('book.create');
  Route::post('/book', 'BooksController@store')->name('book.store');
  Route::get('/book/{book}/edit', 'BooksController@edit')->name('book.edit');
  Route::put('/book/{book}', 'BooksController@update')->name('book.update');
  Route::delete('/book/{book}', 'BooksController@destroy')->name('book.destroy');

  // Categories
  Route::get('/categories', 'ManageController@categories')->name('categories');
  Route::post('/category', 'CategoriesController@store')->name('category.store');
  Route::delete('/category/{category}', 'CategoriesController@destroy')->name('category.destroy');

  // Tags
  Route::get('/tags', 'ManageController@tags')->name('tags');
  Route::post('/tag', 'TagsController@store')->name('tag.store');
  Route::delete('/tag/{tag}', 'TagsController@destroy')->name('tag.destroy');

  // Authors
  Route::get('/authors', 'ManageController@authors')->name('authors');
  Route::post('/author', 'AuthorsController@store')->name('author.store');
  Route::delete('/author/{author}', 'AuthorsController@destroy')->name('author.destroy');

  // Users
  Route::get('/users', 'UsersController@index')->name('users.index');
  Route::delete('/user/{user}', 'UsersController@destroy')->name('user.destroy')->middleware('role:superadministrator|administrator');
  Route::put('/user/{user}', 'UsersController@update')->name('user.update')->middleware('role:superadministrator|administrator');
  // Settings
  Route::get('/settings', 'ManageController@settings')->name('settings');

  // Comments
  Route::get('/comments', 'CommentsController@index')->name('comments');
}); // End admin panel

// Categories
Route::get('categories', 'CategoriesController@index')->name('category.index');
Route::get('category/{category}', 'CategoriesController@show')->name('category.show');
// Tags
Route::get('tags', 'TagsController@index')->name('tag.index');
Route::get('tag/{tag}', 'TagsController@show')->name('tag.show');
// Authors
Route::get('authors', 'AuthorsController@index')->name('author.index');
Route::get('author/{author}', 'AuthorsController@show')->name('author.show');
// Books
Route::get('book/{book}', 'BooksController@show')->name('book.show');
Route::get('download/{book}', 'BooksController@download')->name('book.download');

// Comments
Route::post('{book}/comments', 'CommentsController@store')->middleware('auth')->name('comment.store');
Route::delete('comment/{comment}', 'CommentsController@destroy')->middleware('auth')->name('comment.destroy');

// Search Books
Route::get('search', 'BooksController@search')->name('search');
