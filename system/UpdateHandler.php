<?php

namespace TowerDefense\system;

use pocketmine\Thread;
use TowerDefense\Utils;
use pocketmine\sleeper\SleeperHandler;

class UpdateHandler extends Thread {

    public const LOW = 0;
    public const MEDIUM = 1;
    public const HIGH = 2

    /** @var \ThreadedLogger */
    private $mLogger;
    /** @var \Threaded */
    private $mUpdateData;
    /** @var SleeperHandler */
    private $mSleeper;
    /** @var bool */
    private $mRunning = false;
    /** @var float */
    private $mNextTick = 0;
    /** @var int */
    private $mCurrentTick = 0;
    
    public function __construct(\ClassLoader $pLoader, \ThreadedLogger $pLogger) {
        $this->mLogger = $pLogger;
        $this->setClassLoader($pLoader);
        $this->mSleeper = new SleeperHandler();
        $this->mUpdateData = new \Threaded;
        $this->mRunning = true;
        $this->start();
    }
    
    public function getLogger(): \ThreadedLogger {
        return $this->Logger;
    }
    
    public function push_update(int $pTick, callable $pCallback, int $pPriority = self::LOW): void {
        $id = Utils::generateID(array_keys($this->mCallbacks));
        $this->mUpdateData[$id] = [$pTick, $pCallback, $pPriority];
    }
    
    public function pull(string $pID): void {
        unset($this->mUpdateData[$pID]);
    }
    
    public function run() {
        $this->registerClassLoader();
        $this->mNextTick = microtime(true);
        while($this->mRunning) {
            $this->tick();
            $this->mSleeper->sleepUntil($this->mNextTick);
        }
    }
    
    public function tick(): void {
        $tickTime = microtime(true);
        if(($tickTime - $this->mNextTick) < -0.025) return;
        ++$this->mCurrentTick;
        for($i = 0; $i <= self::HIGH; $i++) {
            foreach($this->mUpdateData as $id => $data) {
                if($i === $data[2]($this->mCurrentTick % $data[0]) === 0) {
                    $data[1]($id, $this->mCurrentTick);
                }
            }
        }
        if(($this->mNextTick - $tickTime) < -1) {
            $this->mNextTick = $tickTime;
        } else {
            $this->mNextTick += 0.05;
        }
    }
    
    public function quit(): void {
        $this->mRunning = false;
        parent::quit();
    }
}
