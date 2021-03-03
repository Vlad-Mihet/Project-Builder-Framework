<?php

namespace app\core\form;

use app\core\Model;

class Field
{

  // Type Safety Input Types
  public const TYPE_TEXT = "text";
  public const TYPE_PASSWORD = "password";
  public const TYPE_NUMBER = "number";
  public const TYPE_TEXTAREA = "textarea";

  public string $type;
  public string $label;
  public Model $model;
  public string $attribute;

  // Field Generic Attributes
  public function __construct(Model $model, string $attribute, string $label, ?string $type = self::TYPE_TEXT)
  {
    $this->type = $type;
    $this->label = $label;
    $this->model = $model;
    $this->attribute = $attribute;
  }

  // Input generation depending on the constructor parameters
  public function __toString()
  {
    if ($this->type === self::TYPE_TEXTAREA) {
      return sprintf(
        '
        <div class="form-group">
          <label>%s</label>
          <textarea name="%s" value="%s" class="form-control%s"></textarea>
          <div class="invalid-feedback">%s</div>
        </div>
      ',
        $this->label,
        $this->attribute,
        $this->model->{$this->attribute},
        $this->model->hasError('firstName') ? ' is-invalid' : '',
        $this->model->getFirstError($this->attribute)
      );
    }

    return sprintf(
      '
      <div class="form-group">
        <label>%s</label>
        <input type="%s" name="%s" value="%s" class="form-control%s" />
        <div class="invalid-feedback">%s</div>
      </div>
    ',
      $this->label,
      $this->type,
      $this->attribute,
      $this->model->{$this->attribute},
      $this->model->hasError('firstName') ? ' is-invalid' : '',
      $this->model->getFirstError($this->attribute)
    );
  }

  // Password Field Resolve
  public function passwordField()
  {
    $this->type = self::TYPE_PASSWORD;
    return $this;
  }

  // Textarea Field Resolve
  public function textareaField()
  {
    $this->type = self::TYPE_TEXTAREA;
    return $this;
  }
}
