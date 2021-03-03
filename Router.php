<?php

namespace vlad_mihet\pbf;

use vlad_mihet\pbf\exception\NotFoundException;

class Router
{

  public Request $request;
  public Response $response;
  protected array $routes = [];

  /**
   * Router Constructor
   * 
   * @param \vlad_mihet\pbf\Request $request
   * @param \vlad_mihet\pbf\Response $response
   */

  public function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  public function get($path, $callback)
  {
    $this->routes['get'][$path] = $callback;
  }

  public function post($path, $callback)
  {
    $this->routes['post'][$path] = $callback;
  }

  public function resolve()
  {
    $path = $this->request->getPath();
    $method = $this->request->method();
    $callback = $this->routes[$method][$path] ?? false;
    if ($callback === false) {
      Application::$app->response->setStatusCode(404);
      throw new NotFoundException();
    }

    if (is_string($callback)) {
      return Application::$app->view->renderView($callback);
    }

    if (is_array($callback)) {
      /** @var \vlad_mihet\pbf\Controller $controller */

      $controller = new $callback[0]();
      Application::$app->controller = $controller;
      $controller->action = $callback[1];
      foreach ($controller->getMiddleware() as $middleware) {
        $middleware->execute();
      }
      $callback[0] = $controller;
    }

    echo call_user_func($callback, $this->request, $this->response);
  }
}
