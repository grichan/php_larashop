<?php


namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Cart;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Post;

class Front extends Controller {

    var $brands;
    var $categories;
    var $products;
    var $title;
    var $description;



     function __construct() {
        $this->brands = Brand::all(array('name'));
        $this->categories = Category::all(array('name'));
        $this->products = Product::all(array('id','name','price'));
    }

    public function index() {
        return view('home', array(
            'title' => 'Welcome',
            'description' => '',
            'page' => 'home',
            'brands' => $this->brands,
            'categories' => $this->categories,
            'products' => $this->products));
    }

    public function products() {
        return view('products', array(
            'title' => 'Products Listing',
            'description' => '',
            'page' => 'products',
            'brands' => $this->brands,
            'categories' => $this->categories,
            'products' => $this->products));
    }

    public function product_details($id) {
        $product = Product::find($id);
        return view('product_details', array(
            'product' => $product,
            'title' => $product->name,
            'description' => '',
            'page' => 'products',
            'brands' => $this->brands,
            'categories' => $this->categories,
            'products' => $this->products));
    }

    public function product_categories($name) {
        $drinks = array('Vodka', 'Gin', 'Brandy', 'Juice');
        return view('product_categories', array(
            'drinks' => $drinks,
            'title' => 'Welcome to Categories',
            'name' =>$name ,
            'description' => 'Our products that we sell',
            'page' => 'products',
            'brands' => $this->brands,
            'categories' => $this->categories,
            'products' => $this->products));
    }

    public function product_brands($name, $category = null) {
        return view('products', array(
            'title' => 'Welcome',
            'description' => '',
            'page' => 'products',
            'brands' => $this->brands,
            'categories' => $this->categories,
            'products' => $this->products));
    }

    // BLOG FUNCTIONS
    public function blog() {
        $posts = Post::where('id', '>', 0)->paginate(3);
        $posts->setPath('blog');

        $data['posts'] = $posts;

        return view('blog', array(
            'data' => $data,
            'title' => 'Latest Blog Posts',
            'description' => '',
            'page' => 'blog',
            'brands' => $this->brands,
            'categories' => $this->categories,
            'products' => $this->products));
    }
    public function blog_post($url) {
        $post = Post::whereUrl($url)->first();

        $tags = $post->tags;
        $prev_url = Post::prevBlogPostUrl($post->id);
        $next_url = Post::nextBlogPostUrl($post->id);
        $title = $post->title;
        $description = $post->description;
        $page = 'blog';
        $brands = $this->products;
        $categories = $this->categories;
        $products = $this->products;

        $data = compact(
            'prev_url',
            'next_url',
            'tags',
            'post',
            'title',
            'description',
            'page',
            'brands',
            'categories',
            'products');

         return view('blog_post', $data);
    }

    public function contact_us() {
        return view('contact_us', array(
            'title' => 'Welcome',
            'description' => '',
            'page' => 'contact_us'));
    }

    // CART ACTIONS
    public function cart() {
        // update/ add new item to cart
         if (Request::isMethod('post')) {
            $product_id = Request::get('product_id');
            $product = Product::find($product_id);
            Cart::add(array(
                'id' => $product_id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price));
        }
        // increment the quantity of cart
        if (Request::get('product_id') && (Request::get('increment')) == 1 ){
             $rowId = Cart::search(array('id' => Request::get('product_id')));
             $item = Cart::get($rowId[0]);

             Cart::update($rowId[0], $item->qty + 1);
        }
        // DECREASE THE QUANTITY OF A CART
        if (Request::get('product_id') && (Request::get('decrease')) == 1){
            $rowId = Cart::search(array('id' => Request::get('product_id')));
            $item = Cart::get($rowId[0]);

            Cart::update($rowId[0], $item->qty - 1);
        }
        // REMOVE ITEM FROM CART
        if ( Request::get('product_id') && Request::get('remove') == 1 ){
            $rowId = Cart::search(array('id' => Request::get('product_id')));

            Cart::remove($rowId[0]);
        }
        // CLEAR ALL ITEMS FROM CART
        if (Request::get('clear') == 1){
            Cart::destroy();
        }
        $cart = Cart::content();

        return view('cart', array(
            'cart' => $cart,
            'title' => 'Welcome',
            'description' => '',
            'page' => 'home'));
    }

    public function checkout() {
        return view('checkout', array(
            'title' => 'Welcome',
            'description' => '',
            'page' => 'home'));
    }

    public function search($query) {
        return view('products', array(
            'title' => 'Welcome',
            'description' => '',
            'page' => 'products'));
    }

    // REGISTER USER
    public function register(){
         if ( Request::isMethod('post') ){
             User::create([
                 'name' => Request::get('name'),
                 'email' => Request::get('email'),
                 'password' => bcrypt(Request::get('password')),
             ]);
         }
         return Redirect::away('login');
    }

    // LOGIN USER
    public function authenticate(){
        if ( Auth::attempt( [
            'email' => Request::get('email'), 'password' => Request::get('password')] ) ){
            return redirect()->intended('checkout');
        } else {
            return view('login', array(
                'title' => 'Welcome', 'description' => '', 'page' => 'home' ) );
        }
    }

    // LOGOUT USER
    public function logout(){
        Auth::logout();
        return Redirect::away('login');
    }
}