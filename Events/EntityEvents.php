<?php

namespace TowerDefense\Events;

use TowerDefense\Loader;
use TowerDefense\api\game\GameManager;
use TowerDefense\api\player\PlayerManager;
use TowerDefense\Tasks\DeathTask;
use pocketmine\event\Listener;
use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
use pocketmine\Player;
use pocketmine\utils\TextFormat as c;
use pocketmine\entity\Entity;

class EntityEvents implements Listener {

  public function onEntityDamage(EntityDamageEvent $event) {
    $entity = $event->getEntity();
    $cause = $event->getCause();
    if($event instanceof EntityDamageByEntityEvent) {
      $damager = $event->getDamager();
      if($entity->namedtag->hasTag("Corpse")) {
        $event->setCancelled(true);
      }
      if($entity instanceof Player && $damager instanceof Player) {
        $entityData = PlayerManager::get()->getPlayer($entity->getName());
        $damagerData = PlayerManager::get()->getPlayer($damager->getName());
        if($entityData->isPlaying() && $damagerData->isPlaying()) {
          $game = GameManager::get()->getGame($damagerData->getGameId());
          if($game->getTeamManager()->getTeamByPlayer($entity) === $game->getTeamManager()->getTeamByPlayer($damager)) {
            $event->setCancelled(true);
            if($entity->getHealth() === 1) {
              if(!$entity->hasTag("Killed")) {
                $nbt = Entity::createBaseNBT($entity);
                $nbt->setTag(clone $entity->namedtag->getCompound("Skin"));
                $human = Entity::createEntity("Human", $entity->getLevel(), $nbt);
                $human->getDataPropertyManager()->setBlockPos($human::DATA_PLAYER_BED_POSITION, $entity);
                $human->setPlayerFlag($human::DATA_PLAYER_FLAG_SLEEP, true);
                $human->spawnToAll();
                $human->despawnFrom($entity);
                $entity->despawnFromAll();
                $entity->setImmobile(true);
                Loader::get()->getScheduler()->scheduleRepeatingTask(new DeathTask($entity, $human), 20);
              } else {
                if($damager->getInventory()->getItemInHand()->getName() === c::RESET . c::BOLD . c::GREEN . "Bandage") {
                  $entity->setHealth(2);
                  $item = $damager->getInventory()->getItemInHand();
                  $item->pop();
                  $damager->getInventory()->setItemInHand($item);
                  foreach($entity->getLevel()->getEntities() as $human) {
                    if($human->namedtag->hasTag("Corpse") && $human->namedtag->getTag("Corpse") === $entity->getName()) {
                      $human->close()
                    }
                  }
                  $entity->setImmobile(false);
                  $entity->spawnToAll();
                  //TODO: Teleport players back to their tower
                }
              }
            }
          }
        }
      }
    }
  }
}
