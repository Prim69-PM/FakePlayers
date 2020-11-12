<?php

namespace xPrim69x\FakePlayers;

use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;

class FakePlayer extends Human {

	private $name;
	private $kb;

	public function __construct(Level $level, CompoundTag $nbt){
		parent::__construct($level, $nbt);
		$this->kb = Main::getInstance()->knockback;
	}

	public function entityBaseTick(int $tickDiff = 1): bool{
		$hasUpdate = parent::entityBaseTick($tickDiff);
		if(!$this->isAlive()){
			return false;
		}
		$hp = round($this->getHealth());
		$this->setNameTag($this->name . " Health $hp");
		return $hasUpdate;
	}

	public function knockBack(Entity $attacker, float $damage, float $x, float $z, float $base = 0.45) : void{
		parent::knockBack($attacker, $damage, $x, $z, $this->kb);
	}

	public function saveNBT(): void{
		$this->namedtag->setString("playername", $this->name);
		parent::saveNBT();
	}

	public function initEntity(): void{
		parent::initEntity();
		$this->name = $this->namedtag->getString("playername");
	}

}