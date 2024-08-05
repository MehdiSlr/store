<?php

require_once __DIR__.'/router.php';

// ##################################################
// ##################################################
// ##################################################


// die('here');
$base_path = '/store';
// var_dump($base_path);
// Static GET
// In the URL -> http://localhost
// The output -> Index
get($base_path , 'views/index.php');

get("$base_path/login", 'views/auth/login.php');

get("$base_path/signup", 'views/auth/register.php');

get("$base_path/logout", 'views/auth/logout.php');

get("$base_path/forgot-password", 'views/auth/forgot.php');

get("$base_path/verify", 'views/auth/verify.php');

get("$base_path/reset-password", 'views/auth/respass.php');

post("$base_path/auth", 'views/auth/auth.php');

get("$base_path/404", 'views/404.php');


get("$base_path/shop", 'views/shop.php');

get("$base_path/product", 'views/product.php');

any("$base_path/cart", 'views/cart.php');

// any('/test', 'test.php');
any('/pajax', 'pajax.php');
// any('/import', 'views/admin/import.php');
get("$base_path/addtocart", 'add_to_cart.php');
any("$base_path/checkout", 'views/checkout.php');

// Admin Section
get("$base_path/admin/dashboard", 'views/admin/pages/dashboard.php');
get("$base_path/template", 'views/admin/template.php');
any("$base_path/admin/site-settings", 'views/admin/pages/settings.php');
any("$base_path/admin/admins", 'views/admin/pages/admins.php');
any("$base_path/admin/products", 'views/admin/pages/products.php');


// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
get('/user/$id', 'views/user');

// Dynamic GET. Example with 2 variables
// The $name will be available in full_name.php
// The $last_name will be available in full_name.php
// In the browser point to: localhost/user/X/Y
get('/user/$name/$last_name', 'views/full_name.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
get('/product/$type/color/$color', 'product.php');

// A route with a callback
get('/callback', function(){
  echo 'Callback executed';
});

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
get('/callback/$name', function($name){
  echo "Callback executed. The name is $name";
});

// Route where the query string happends right after a forward slash
get('/product', '');

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
get('/callback/$name/$last_name', function($name, $last_name){
  echo "Callback executed. The full name is $name $last_name";
});

// ##################################################
// ##################################################
// ##################################################
// Route that will use POST data
post('/user', '/api/save_user');



// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');


