<?php

namespace TowerDefense\api\managers;

use TowerDefense\Loader;
use TowerDefense\api\entities\Area;
use pocketmine\utils\Config;
use pocketmine\math\Vecotr3;

class AreaManager {
  
  private static $instance;
  
  private $areas = [];
  
  public function __construct() {
    self::$instance = $this;
  }
  
  public static function get() {
    return self::$instance;
  }
  
  public function getArea(string $area) {
    return isset($this->areas[strtolower($area)]) ? $this->areas[strtolower($area)] : null;
  }
  
  public function getAreas() {
    return $this->areas;
  }
  
  public function createArea(string $name, Vector3 $min, Vector3 $max) {
    $area = new Area($name, $min, $max);
    $this->areas[strtolower($name)] = $area;
    return $area;
  }
  
  public function loadData() {
    $config = new Config(Loader::get()->getDataFolder() . "Areas.json", Config::JSON);
    foreach($config->getAll() as $k => $v) {
      $this->areas[strtolower($k)] = new Area($k, new Vector3($v["minX"], $v["minY"], $v["minZ"]), new Vector3($v["maxX"], $v["maxY"], $v["maxZ"]));
    }
    unlink(Loader::get()->getDataFolder() . "Areas.json");
  }
  
  public function saveData() {
    foreach($this->areas as $area) {
      $config = new Config(Loader::get()->getDataFolder() . "Areas.json", Config::JSON);
      $pos = [];
      $pos["minX"] = $area->getMin()->getX();
      $pos["minY"] = $area->getMin()->getY();
      $pos["minZ"] = $area->getMin()->getZ();
      $pos["maxX"] = $area->getMax()->getX();
      $pos["maxY"] = $area->getMax()->getY();
      $pos["maxZ"] = $area->getMax()->getZ();
      $config->set($area->getName(), $pos);
      $config->save();
    }
  }
}
