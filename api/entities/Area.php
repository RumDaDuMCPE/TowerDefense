<?php

namespace TowerDefense\api\entities;

class Area {

  private $name;

  private $min;
  private $max;
  
  public function __construct(string $name, Vector3 $min, Vector3 $max) {
    $this->name = $name;
    $this->min = $min;
    $this->max = $max;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function getMin() {
    return $this->min;
  }
  
  public function getMax() {
    return $this->max;
  }
}
