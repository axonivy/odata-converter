<?php
namespace app;

use DI\Container;
use Middlewares\TrailingSlash;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use Throwable;

class Website
{
  private $app;

  function __construct()
  {
    $container = new Container();
    $this->app = AppFactory::createFromContainer($container);
    $view = $this->configureTemplateEngine();
    $this->installTrailingSlashRedirect();
    $this->installRoutes();
    $this->installErrorHandling();
  }

  public function getApp(): App
  {
    return $this->app;
  }

  public function start()
  {
    $this->app->run();
  }

  private function configureTemplateEngine(): Twig
  {
    $container = $this->app->getContainer();

    $this->app->getContainer()->set(Twig::class, function (ContainerInterface $container) {
      return Twig::create(__DIR__ . '/../app/pages');
    });

    $view = $container->get(Twig::class);
    return $view;
  }

  private function installTrailingSlashRedirect()
  {
    $this->app->add((new TrailingSlash(false))->redirect());
  }

  private function installRoutes()
  {
    RoutingRules::installRoutes($this->app);
  }

  private function installErrorHandling()
  {
    $container = $this->app->getContainer();
    $errorMiddleware = $this->app->addErrorMiddleware(true, true, true);
    $errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails) use ($container) {
      $response = new Response();
      return $container->get(Twig::class)
        ->render($response, '_error/404.twig')
        ->withStatus(404);
    });
/*
    if (Config::isProductionEnvironment()) {
      $errorMiddleware->setDefaultErrorHandler(function (ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails) use ($container) {
        $response = new Response();
        $data = ['message' => $exception->getMessage()];
        return $container->get(Twig::class)
          ->render($response, '_error/500.twig', $data)
          ->withStatus(500);
      });
    }*/
  }
}
