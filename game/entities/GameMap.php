<?php

namespace TowerDefense\game\entities;

use TowerDefense\Loader;
use TowerDefense\system\Schematic;
use pocketmine\utils\BinaryStream;
use pocketmine\nbt\BigEndianNbtSerializer;
use pocketmine\math\Vector3;

class GameMap {
  
  /** @var string */
  private $mName;
  /** @var Schematic */
  private $mSchematic;
  
  public function __construct(string $pName) {
    $this->mName = $pName;
  }
  
  public function getName(): string {
    return $this->mName;
  }
  
  public function paste(Vector3 $pVector): void {
    for($x = 0; $x < $this->mSchematic->getWidth(); $x++) {
      for($z = 0; $z < $this->mSchematic->getLength(); $z++) {
        for(y = 0; $y < $this->mSchematic->getHeight(); $y++) {
          
        }
      }
    }
  }
  
  final public function setSchematic(Schematic $pSchematic): void {
    $this->mSchematic = $pSchematic;
  }
  
  public function save(): void {
    if(file_exists(Loader::get()->getDataFolder() . "maps/" . $this->getName() . ".map")) return;
    $stream = new BinaryStream();
    $schematic = $this->mSchematic->save();
    $stream->putUnsignedVarInt(strlen($schematic));
    $stream->put($schematic);
    file_put_contents(Loader::get()->getDataFolder() . "maps/" . $this->getName() . ".map", $stream->getBuffer());
  }
  
  public static function load(string $pName): ?GameMap {
     if(!file_exists($file = Loader::get()->getDataFolder() . "maps/" . $pName . ".map")) return;
     $stream = new BinaryStream($file);
     $map = new GameMap($pName);
     $schematic = new Schematic();
     $schematic->parse($stream->get($stream->getUnsignedVarInt()));
     $map->setSchematic($schematic);
     return $map;
  }
}
