<?php

namespace vlad_mihet\pbf;

class View
{
  public string $title = '';

  public function renderView($view, $params = [])
  {
    $viewContent = $this->renderOnlyView($view, $params);
    $layoutContent = $this->layoutContent();
    return str_replace('{{content}}', $viewContent, $layoutContent);
    include_once Application::$ROOT_DIR . "/views/$view.php";
  }

  public function renderContent($viewContent)
  {
    $layoutContent = $this->layoutContent();
    return str_replace('{{content}}', $viewContent, $layoutContent);
  }

  protected function layoutContent()
  {
    $layout = Application::$app->controller;
    if (Application::$app->controller) {
      $layout = Application::$app->controller->layout;
    }
    ob_start(); // Output caching operation
    include_once Application::$ROOT_DIR . "/views/layouts/main.php";
    return ob_get_clean(); // Returns and clears the buffer
  }

  protected function renderOnlyView($view, $params)
  {
    foreach ($params as $key => $value) {
      $$key = $value;
    }

    ob_start(); // Output caching operation
    include_once Application::$ROOT_DIR . "/views/$view.php";
    return ob_get_clean(); // Returns and clears the buffer
  }
}
