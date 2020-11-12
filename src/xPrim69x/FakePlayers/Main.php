<?php

namespace xPrim69x\FakePlayers;

use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

	public static $instance;
	public $knockback;

	public function onEnable(){
		$this->getServer()->getCommandMap()->register($this->getName(), new FakePlayerCommand());
		$this->init();
	}

	public function init(){
		self::$instance = $this;
		Entity::registerEntity(FakePlayer::class, true);
		$this->knockback = $this->getConfig()->get('knockback');
	}

	public static function getInstance() : Main{
		return self::$instance;
	}

}
