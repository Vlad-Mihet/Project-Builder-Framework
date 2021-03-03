<?php

namespace app\core;

use app\core\Application;
use app\core\middleware\BaseMiddleware;

class Controller
{

  public string $action = '';
  public string $layout = 'main';

  /**
   * @var \app\core\middleware\BaseMiddleware[]
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
