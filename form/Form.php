<?php

namespace vlad_mihet\pbf\form;

use \vlad_mihet\pbf\form\Field;
use \vlad_mihet\pbf\Model;

class Form
{
  public static function begin($action, $method)
  {
    echo sprintf('<form action="%s" method="%s">', $action, $method);
    return new Form();
  }

  public static function end()
  {
    echo '</form>';
  }

  public function field(Model $model, $attribute, $label)
  {
    return new Field($model, $attribute, $label);
  }
}
