<?php
/*
 * DB connection parameters
 */
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', 'xxxxxx');
define('DB_NAME', 'hqtest');

define('DB_TABLE', 'hqtest_order');

/*
 * Paypal Credentials
 */
define('PAYPAL_ENVIRONMENT', 'sandbox'); // for sandbox mode
//define('PAYPAL_ENVIRONMENT', 'live'); // for live mode
define('PAYPAL_API_CLIENTID', 'AdrVuBA72swvrff941X3b49ymOanjTNgwYE6dQE0qyij5wm8o5wZtnxPWzbI');
define('PAYPAL_API_SECRET', 'EOOn-BDR3gp95ZA8tHiN-Am3A2XWcxw12SpmwCO6A1EX2FHXwyZgLbSJigu_');

/*
 * Brain Tree Credentaials
 */
define('BRAINTREE_ENVIRONMENT', 'sandbox'); // for sandbox mode
//define('BRAINTREE_ENVIRONMENT', 'production'); // for production mode
define('BRAINTREE_MERCHANTID', 'phg8vjpqtndv7vxt');
define('BRAINTREE_PUBLICKEY', 'fv8jmr75kkm7bcmd');
define('BRAINTREE_PRIVATEKEY', '548b5c53f1894d9090a1a05f63c1be53');

// Default Pament method for teh system
define('DEFAULT_PAYMENT_GATEWAY', 'braintree');


?>