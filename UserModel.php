<?php

namespace vlad_mihet\pbf;

use vlad_mihet\pbf\db\DbModel;

abstract class UserModel extends DbModel
{
  abstract public function getDisplayName(): string;
}
