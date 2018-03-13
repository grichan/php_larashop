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

use App\User;
use Illuminate\Support\Facades\Auth;


Route::get('/','Front@index');
Route::get('/products','Front@products');
Route::get('/products/details/{id}','Front@product_details');
Route::get('/products/categories/{name}','Front@product_categories');


Route::get('/products/brands','Front@product_brands');
Route::get('/blog','Front@blog');
Route::get('/blog/post/{id}','Front@blog_post');
Route::get('/contact-us','Front@contact_us');

// Authentication
Route::get('auth/login','Front@login');
Route::get('auth/login','Front@authenticate');
Route::post('auth/login','Front@authenticate');
Route::get('auth/logout','Front@logout');
function authenticate() {
    if (Auth::attempt(['email' => Request::get('email'), 'password' => Request::get('password')])) {
        return redirect()->intended('checkout');
    } else {
        return view('login', array('title' => 'welcome', 'description' => '', 'page' => 'home'));
    }
}

// Register
Route::post('/register', 'Front@register');
function register() {
    if(Request::isMethod('post')){
        User::create([
           'name' => Request::get('name'),
           'email' => Request::get('email'),
           'password' => bcrypt(Request::get('password')),
        ]);
    }
    return Redurect::away('login');
}


Route::get('/cart','Front@cart');
Route::get('/checkout', ['middleware' => 'auth', 'uses' => 'Front@checkout']);
Route::get('/search/{query}','Front@search');

Route::get('blade', function(){
    $drinks = array('Vodka', 'Gin', 'Brandy', 'Juice');
    return view('page', array('name' => 'The Raven', 'day' => 'Wednesday', 'drinks' => $drinks));
});

Route::post('/cart', 'Front@cart');



// INSERT
Route::get('/insert', function (){
   App\Category::create(array('name' => 'Music'));
   return 'category added';
});

// READ
Route::get('/read', function (){
   $category = new App\Category();
   $data = $category->all(array('name', 'id'));

    foreach ($data as $list) {
        echo $list->id . ' ' . $list->name . ' ';
   }
});

// UPDATE
Route::get('/update', function (){
    $category = App\Category::find(6); // 16 - primary key param
    $category->name = 'HEAVY METAL';
    $category->save();

    $data = $category->all(array('name', 'id'));

    foreach ($data as $list){
        echo $list->id . ' ' . $list->name . ' ';
    }
});

// DELETE
Route::get('/delete', function (){
   $category = App\Category::find(5);
   $category->delete();

   $data = $category->all(array('name', 'id'));

   foreach ($data as $list) {
       echo $list->id . " " . $list->name . " ";
   }
});

