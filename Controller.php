<?php

namespace vlad_mihet\pbf;

use vlad_mihet\pbf\Application;
use vlad_mihet\pbf\middleware\BaseMiddleware;

class Controller
{

  public string $action = '';
  public string $layout = 'main';

  /**
   * @var \vlad_mihet\pbf\middleware\BaseMiddleware[]
   */
  protected array $middlewares = [];


  public function __construct()
  {
  }

  public function setLayout($layout)
  {
    $this->layout = $layout;
  }

  public function render($view, $params = [])
  {
    return Application::$app->view->renderView($view, $params);
  }

  public function registerMiddleware(BaseMiddleware $middleware)
  {
    $this->middlewares[] = $middleware;
  }

  public function getMiddleware()
  {
    return $this->middlewares;
  }

  public function setMiddleware()
  {
  }
}
