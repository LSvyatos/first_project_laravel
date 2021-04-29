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

/*Route::get('/', function () {
    return view('main');
});*/

//Route::get('/', 'ContactController@submit');

//Route::get('/contact',function(){
//   return view('contact');
// });
// Route::post('/contact/submit','ContactController@submit')->name('contact-form');


Route::any('/login',function(){
    return view('login');
})->name("login");

Auth::routes();

Route::prefix('guest')->group(function()
{
    Route::prefix('vacancy')->group(function()
    {
      Route::get('/search', 'Vacancy\Search@go');

     });
});

Route::prefix('api')->middleware(['auth','checkAccess','cors'])->group(function () {

    Route::prefix('images')->group(function()
    {
     Route::any('/upload', 'Images\Upload@save');
     Route::any('/{id}/get',"Images\Get@go");
    });

    Route::prefix('vacancy')->group(function()
    {
      Route::prefix('category')->group(function(){
      Route::post('/search', 'Vacancy\Category\Search@go');
      Route::any('/{id}', 'Vacancy\Category\Get@go');
      Route::put('/{id}/edit', 'Vacancy\Category\Edit@go');
      Route::post('/add', 'Vacancy\Category\Create@go');
      Route::delete('/{id}/delete','Vacancy\Category\Delete@go');
     });

     Route::prefix('image')->group(function(){
       Route::any("/add","Vacancy\Images\Create@go");
       Route::any("{get}/get","Vacancy\Images\Get@go");
      });

     Route::prefix('client')->group(function(){
           Route::get('/{vacancy}/search', 'Vacancy\Clients\Search@go');
           Route::get('/{id}', 'Vacancy\Clients\Get@go');
           Route::put('/{id}/edit', 'Vacancy\Category\Edit@go');
           Route::get('{vacancy}/add', 'Vacancy\Clients\Create@go');
           Route::get('/{id}/delete','Vacancy\Clients\Delete@go');
     });

     Route::post('/data','Data\Get@get');

     Route::post('/search', 'Vacancy\Search@go');
     Route::post('/{id}', 'Vacancy\Get@go');
     Route::put('/{id}/edit', 'Vacancy\Edit@go');
     Route::post('/add', 'Vacancy\Create@go');
     Route::delete('/{id}/delete','Vacancy\Delete@go');
    });

    Route::prefix('routes')->group(function()
    {
     Route::post('/data','Data\Get@routes');
     Route::post('/search', 'Routes\Search@go');
     Route::post('/{id}', 'Routes\Get@go');
     Route::put('/{id}/edit', 'Routes\Edit@go');
     Route::post('/add', 'Routes\Create@go');
     Route::delete('/{id}/delete', 'Routes\Delete@go');
     Route::post('perhaps', 'Trips\Perhaps\Search@go');
    Route::prefix('route')->group(function()
    {
     Route::post('/data','Data\Get@route');
     Route::post('/search', 'Routes\Children\Search@go');
     Route::post('/{id}', 'Routes\Children\Get@go');
     Route::put('/{id}/edit', 'Routes\Children\Edit@go');
     Route::post('/add', 'Routes\Children\Create@go');
     Route::delete('/{id}/delete', 'Routes\Children\Delete@go');
    });
    });

    Route::prefix('users')->group(function()
    {
     Route::post('/search', 'Users\Search@go');
     Route::post('/drivers', 'Users\Search@drivers');
     Route::post('/{id}', 'Users\Get@go');
     Route::put('/{id}/edit', 'Users\Edit@go');
     Route::post('/add', 'Users\Create@go');
     Route::delete('/{id}/delete', 'Users\Delete@go');
     Route::post('/data','Data\Get@users');
    });

    Route::prefix('client')->group(function()
    {
     Route::post('/search', 'Clients\Search@go');
     Route::post('/{id}', 'Clients\Get@go');
     Route::put('/{id}/edit', 'Clients\Edit@go');
     Route::post('/add', 'Clients\Create@go');
     Route::delete('/{id}/delete','Clients\Delete@go');
    });

    Route::prefix('trip')->group(function()
    {
     Route::prefix('perhap')->group(function()
     {
      Route::post('/search', 'Trips\Perhaps\Search@go');
      Route::post('/{id}', 'Trips\Perhaps\Get@go');
     });     
     Route::post('/data', 'Data\Get@trips');
     Route::post('/search', 'Trips\Search@go');
     Route::post('/{id}', 'Trips\Get@go');
     Route::put('/{id}/edit', 'Trips\Edit@go');
     Route::post('/add', 'Trips\Create@go');
     Route::delete('/{id}/delete','Trips\Delete@go');
    });

    Route::prefix('ticket')->group(function()
    {
     Route::post('/search', 'Tickets\Search@go');
     Route::post('/{id}', 'Tickets\Get@go');
     //Route::put('/{id}/edit', 'Tickets\Edit@go');
     Route::post('/add', 'Tickets\Create@go');
     Route::delete('/{id}/delete','Tickets\Delete@go');
     Route::post('/data','Data\Get@tickets');
     Route::post('/report','Tickets\Report@go');
    });
    Route::prefix('transport')->group(function()
    {
     Route::post('/search', 'Transports\Search@go');
     Route::post('/{id}', 'Transports\Get@go');
     Route::put('/{id}/edit', 'Transports\Edit@go');
     Route::post('/add', 'Transports\Create@go');
     Route::delete('/{id}/delete','Transports\Delete@go');
     Route::post('/data','Data\Get@transport');
    });
    Route::prefix('application')->group(function()
    {
     Route::post('/search', 'Applications\Search@go');
     Route::post('/{id}', 'Applications\Get@go');
     Route::put('/{id}/edit', 'Applications\Edit@go');
     Route::post('/add', 'Applications\Create@go');
     Route::delete('/{id}/delete','Applications\Delete@go');
     Route::post('/data','Data\Get@applications');
    });

     Route::prefix('city')->group(function(){
           Route::post('/search', 'Geography\City\Search@go');
           Route::post('/{id}', 'Geography\City\Get@go');
           Route::post('/add', 'Geography\City\Create@go');
           Route::put('/{id}/edit', 'Geography\City\Edit@go');
           Route::delete('/{id}/delete','Geography\City\Delete@go');
           Route::post('/data','Data\Get@city');
     });

     Route::prefix('country')->group(function(){
           Route::post('/search', 'Geography\Country\Search@go');
           Route::post('/{id}', 'Geography\Country\Get@go');
           Route::post('/add', 'Geography\Country\Create@go');
           Route::put('/{id}/edit', 'Geography\Country\Edit@go');
           Route::delete('/{id}/delete','Geography\Country\Delete@go');
     });

     Route::prefix('region')->group(function(){
           Route::post('/search', 'Geography\Region\Search@go');
           Route::post('/{id}', 'Geography\Region\Get@go');
           Route::post('/add', 'Geography\Region\Create@go');
           Route::put('/{id}/edit', 'Geography\Region\Edit@go');
           Route::delete('/{id}/delete','Geography\Region\Delete@go');
           Route::post('/data','Data\Get@region');
     });
});

Route::get('/images/{filename}', 'Images\Get@displayImage')->name('image.displayImage');

Route::get('/base', 'base@go');

Route::get('/', function()
{
 return redirect('/vacancyActive');
})->where('any','.*')->middleware('auth');

Route::get('/ticket/print',function()
{
           return view('ticket');
 });

Route::get('/home', function()
{
 return redirect('/vacancyActive');
})->where('any','.*')->middleware('auth');

Route::get('/{any?}', function()
{
 return view('admin');
})->where('any','.*')->middleware('auth');
