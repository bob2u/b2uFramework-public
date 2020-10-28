<?php
error_reporting(0);
set_time_limit(300);

include("b2u.min.php");

// default action. this plugin can be used to display the main landing
// page at the root of the site, or completely bypassed by setting the
// "/" plugin to a new directory with an index.php and index plugin in
// the file as the main entry into the website/app.
//
// This index class should be removed once a new "/" root directory is
// set with an index.php and class definition, but if this index is to
// remain then the index.php should be in a unique namespace, and must
// return the __NAMESPACE__ at the end of the index.php file.
class index extends \B2U\Core\Action implements \B2U\Core\IAction {	
	function __construct(& $params, & $response) {
		parent::__construct($params, $response);
		$this->Response->setHeader("Content-Type", "text/html")
						->setContent("<h1>Welcome to B2uFramework</h1>");
	}
}

// plugins define directories where action (files) will be stored
// and these actions will contain methods that can be called from
// the broswer or curl calls or other forms of requests to server
//
// Default plugin is the "/" and will point to the root directory
// which can be modified by providing it in setup options. also a
// default action tied to index.php (i.e. index/) is defined when
// no action is provided. So the default plugin is root and index
// is the default action - this means in the root there must be a
// file named index.php (will be by default) with a class defined
// as "index" extends B2U\Core\Action implements B2U\Core\IAction
// unless user overwrites the "/" root plugin to point to another
// directory, which should contain the default index/entry action
//
// Interfaces are global supported resources by the b2uFrameworks
// to be accessible for all plugins using the getInterface() call
// An interface is a feature loaded on script startup and derived
// from IInterface class to overload specific functions. The keys
// to each interface module is the class name of the main objects
// that the module loaded will produce. The value can be either a
// directory to the root of the module, which will load all files
// with .php extensions, or a specific php file to include like a
// autoloader for the entire module.
\B2U\Core\Manager::instance()->setup([
	"Errors" => [
	   "Report" => E_ALL,
	   "Callback" => function($error, $errno, $errstr, $errfile, $errline) {
	      // $error will contain an array with last error information.
	      //
	      // example below provides the stack and error details in raw
	      // format. The application should decide how to handle error
	      // results.
	      if (!empty($error)) {
		 var_dump($error);
	      }
	      $stack = debug_backtrace();
	      if (count($stack) > 1) {
		 var_dump($stack);
	      }      
	   }
	]
]);

// if desired, at this point the session is still not created and
// a custome session handler can be added using \B2U\Core\Session
// ::setHandlers(...) function. if the desire is to use databases
// to manage sessions you can access the database interfaces here
// calling Manager::instance()->getInterface("Database", ...) and
// perform any action desired.
//
// once the setup is complete the request is parsed, routed to an
// action, and possibly method, and final response is echoed back
\B2U\Core\Manager::instance()->run();
