<?php
/* ------------------------------------------------------------------
	slim configs 
------------------------------------------------------------------ */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/* composer require tuupola/cors-middleware */
use Tuupola\Middleware\CorsMiddleware;

// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;

/* ------------------------------------------------------------------
	slim configs ENDS
------------------------------------------------------------------ */


/* ------------------------------------------------------------------
	require components
------------------------------------------------------------------ */
define("ROOT_PATH", dirname(__FILE__));

require_once $ROOT_PATH . '../vendor/autoload.php';


require_once $ROOT_PATH . '../src/DataAccessLayer/CourseDataAccess.php';

/* ------------------------------------------------------------------
	require components ENDS
------------------------------------------------------------------ */
/* ------------------------------------------------------------------
	app config/settigs 
------------------------------------------------------------------ */
$app = new \Slim\App([
    "settings" => [
        "determineRouteBeforeAppMiddleware" => true,

        // install and use monolog logger
        // 'logger' => [
        //     'name' => 'slim-app',
        //     'level' => Monolog\Logger::DEBUG,
        //     'path' => __DIR__ . '/../logs/app.log',
        // ],
    ],
]);;
/* ------------------------------------------------------------------
	app config/settigs ENDS
------------------------------------------------------------------ */



/* ------------------------------------------------------------------
	app middleware handlers 
------------------------------------------------------------------ */
$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => ["Content-Type", "Access-Control-Allow-Headers", "Authorization", "X-Requested-With"],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));

/* ------------------------------------------------------------------
	app middleware handlers ENdS
------------------------------------------------------------------ */




/* ------------------------------------------------------------------
	app routing handler 
------------------------------------------------------------------ */
$app->group('/courses', function () use ($app) {
	$app->get('/', 'getCourse');
	$app->get('/{id}', 'getCourse');
	
	
});

$app->run();
/* ------------------------------------------------------------------
	app routing handler 
------------------------------------------------------------------ */





/* functions for app-group routes calls */


// will be included in other files
function getCourse ($request, $response, $argv) {
	
	if ( $argv ) {
		$id = json_encode(($argv['id']));
	}
    $course = new CourseDataAccess();   // company settings data layer
    $result = $course->readCourseBy($id);
    return $result;
}


?>