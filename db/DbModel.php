<?php

namespace vlad_mihet\pbf\db;

use \vlad_mihet\pbf\Model;

use \vlad_mihet\pbf\Application;

abstract class DbModel extends Model
{
  abstract static public function tableName(): string;

  abstract public function attributes(): array;

  abstract static public function primaryKey(): string;

  public function save()
  {
    $tableName = $this->tableName();
    $attributes = $this->attributes();
    $params = array_map(fn ($attr) => ":$attr", $attributes);
    $statement = self::prepare("
      INSERT INTO $tableName (" . implode(',', $attributes) . ") 
      VALUES (" . implode(',', $params) . ")
    ");
    foreach ($attributes as $attribute) {
      $statement->bindValue(":$attribute", $this->{$attribute});
    }

    $statement->execute();
    return true;
  }

  public static function prepare($sql)
  {
    return Application::$app->db->pdo->prepare($sql);
  }

  public static function findOne($where) // [email => test@test.com, firstname => test1234] 
  {
    $tableName = static::tableName();
    $attributes = array_keys($where);
    $sql = implode("AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));
    $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
    foreach ($where as $key => $value) {
      $statement->bindValue(":$key", $value);
    }

    $statement->execute();
    // Return User Instance
    return $statement->fetchObject(static::class);
  }
}
