<?php
require_once('router.php');

/**
 * Routes that simply load a page.
 */
get('/', VIEW . 'home.php');

//Routes for login system
get('/login-member', VIEW . 'login/mem_login.php');
get('/signup-member', VIEW . 'login/mem_signup.php');
get('/login-employee', VIEW . 'login/emp_login.php');
get('/signup-employee', VIEW . 'login/emp_signup.php');
get('/logout', VIEW . 'login/logout.php');
get('/user', VIEW . 'view_profile.php');

//Routes for booking system
get('/rooms', VIEW . 'rooms/rooms.php');
get('/booking', VIEW . 'booking/booking.php');
get('/billing', VIEW . 'booking/billing.php');

//Routes for employee accounts
get('/emp-panel', VIEW . 'emp/emp_panel.php');
get('/emp', VIEW . 'emp/emp_profile.php');

//Routes for rating system
get('/reviews', VIEW . 'review/reviews.php');
get('/rating', VIEW . 'review/rating.php');

//Routes for room pages
get('/standard', VIEW . 'rooms/standard.php');
get('/standard-family', VIEW . 'rooms/standard_family.php');
get('/deluxe', VIEW . 'rooms/deluxe.php');
get('/deluxe-family', VIEW . 'rooms/deluxe_family.php');
get('/suite', VIEW . 'rooms/suite.php');

//Routes for discount system
get('/discounts', VIEW . 'discount/view_discounts.php');
get('/add-discount', VIEW . 'discount/add_discount.php');

/**
 * POST method routes. Mainly used for <form> actions.
 */
//Login routes
post('/login-member', APP . 'login_out/process_mem_login.php');
post('/signup-member', APP . 'login_out/process_mem_signup.php');
post('/login-employee', APP . 'login_out/process_emp_login.php');
post('/signup-employee', APP . 'login_out/process_emp_signup.php');
post('/logout', VIEW . 'login/logout.php');

//Booking routes
post('/booking', VIEW . 'booking/booking.php');
post('/billing', VIEW . 'booking/billing.php');

//Rating routes
post('/rating', VIEW . 'review/rating.php');

//Misc
post('/emp-panel', VIEW . 'emp/emp_panel.php');

//Discount routes
post('/add-discount', VIEW . 'discount/add_discount.php');
get('/delete-discount', VIEW . 'discount/delete_discount.php');


/**
 * Error handling.
 * ANY SHOULD ALWAYS BE THE LAST ROUTE.
 */
get('/not-allowed', VIEW . 'not_allowed.php');
any('/404', VIEW . '404.php');