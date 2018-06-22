<?php

namespace TowerDefense\api\game\entities;

use TowerDefense\api\entities\Area;

class Tower {
  
  private $area;
  private $data = [];
  
  public function __construct(Area $area) {
    $this->area = $area;
    $this->data["core_level"] = 1;
    $this->data["shop_level"] = 1;
  }
  
  public function getArea() {
    return $this->area;
  }
  
  public function updateData(string $upgrade, $data) {
    $this->data[$upgrade] = $data;
  }
  
  public function getData() {
    return $this->data;
  }
}
