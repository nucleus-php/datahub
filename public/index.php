<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// @todo this is not Windows safe where the full path would start with a drive (C:\)
define('ROOT_DIR', dirname(dirname(
    substr($_SERVER['SCRIPT_FILENAME'], 0, strlen(DIRECTORY_SEPARATOR)) !== DIRECTORY_SEPARATOR
    ? getcwd() . DIRECTORY_SEPARATOR . $_SERVER['SCRIPT_FILENAME']
    : $_SERVER['SCRIPT_FILENAME']
)));

require ROOT_DIR . '/vendor/autoload.php';

/**
 * @todo Big index.php refactor 1.: Basic setup stays in index.php
 * @todo Big index.php refactor 2.: Move request in, response out to App (Http v.s. Cli?) class
 * @todo Big index.php refactor 3.: Move Routing related things into class for routing as member of the App class
 */

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$routerContainer = new Aura\Router\RouterContainer();
$map = $routerContainer->getMap();

$map->post('entity.event.rest-api', '/rest/event/entity/{entity_type}/{action}')
    ->handler(function ($request) {
        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        /**
         * @todo Big index.php refactor 4. > handler refactor A.: Move to REST handler
         * @todo Big index.php refactor 4. > handler refactor B.: Pass entity type and entity data to entity factory
         * @todo Big index.php refactor 4. > handler refactor C.: Pass entity object to entity dispatcher
         */
        $entityType = $request->getAttribute('entity_type');
        $action = $request->getAttribute('action');

        $entityDataString = (string)$request->getBody();
        if (false !== strpos($request->getHeader('Content-Type')[0], '/xml')) {
            $entityDataString = json_encode(simplexml_load_string($entityDataString, \SimpleXMLElement::class, LIBXML_NOCDATA));
        }
        $entityData = json_decode($entityDataString, true);

        (new \NucleusPhp\DataHub\Event\Dispatcher\Dispatcher(
            new \NucleusPhp\DataHub\Event\EntityEvent([$entityType, $action], $entityData)
        ))->dispatch();

        $response = new Zend\Diactoros\Response();
        $response->getBody()->write(
            json_encode($entityData)
        );

        return $response;
    });

$map->get('entity.job.rest-api', '/rest/job/entity/{entity_type}/{job}')
    ->handler(function ($request) {
        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        /**
         * @todo Big index.php refactor 5. > handler refactor A, B, C.: Same as for events...
         */
        $entityType = $request->getAttribute('entity_type');
        $job = $request->getAttribute('job');

        $jobData = $request->getQueryParams();

        (new \NucleusPhp\DataHub\Job\Runner\Runner(
            new \NucleusPhp\DataHub\Job\EntityJob([$entityType, $job], $jobData)
        ))->dispatch();

        $response = new Zend\Diactoros\Response();
        $response->getBody()->write(
            json_encode($jobData)
        );

        return $response;
    });

$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);

if (!$route) {
    $failedRoute = $matcher->getFailedRoute();

    switch ($failedRoute->failedRule) {
        case 'Aura\Router\Rule\Allows':
            header('HTTP/1.0 405 Method Not Allowed');
            header('Allow: ' . strtoupper(implode(', ', $failedRoute->allows)));
            break;
        case 'Aura\Router\Rule\Accepts':
            header('HTTP/1.0 406 Not Acceptable');
            break;
        default:
            header('HTTP/1.0 404 Not Found');
            break;
    }
    exit;
}

foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

$callable = $route->handler;
/** @var \Psr\Http\Message\ResponseInterface $response */
$response = $callable($request);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
echo $response->getBody();
