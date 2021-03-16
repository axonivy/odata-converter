<?php
namespace app;

use app\pages\home\HomeAction;
use Slim\App;
use app\pages\pickup\PickupAction;

class RoutingRules
{
  public static function installRoutes(App $app)
  {
    $app->get('/', HomeAction::class);
    $app->post('/', HomeAction::class);
    
    $app->get('/pickup/{id}', PickupAction::class);
  }
}
