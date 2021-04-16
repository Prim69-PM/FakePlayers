<?php

namespace xPrim69x\FakePlayers;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class FakePlayerCommand extends Command {

	public function __construct(){
		parent::__construct(
			"fakeplayer",
			TF::AQUA . "Spawn in a fake player!",
			TF::RED . "Usage: " . TF::GRAY . "/fp [def:armor]"
		);
		$this->setAliases(["fp"]);
	}

	public function execute(CommandSender $player, string $commandLabel, array $args){
		if(!$player instanceof Player) return false;
		if(!$player->hasPermission('fakeplayers.spawn')){
			$player->sendMessage(TF::DARK_RED . 'You do not have permission to use this command!');
			return false;
		}
		if(count($args) < 1){
			$player->sendMessage($this->usageMessage);
			return false;
		}
		if($player->namedtag->getTag("Skin") === null){
			$player->kick(TF::RED . 'It seems that this is your first time joining. Your player data file needs to be saved before the fake player can copy your skin. Please rejoin.',false);
			return false;
		}
		if($args[0] === 'def' || $args[0] === 'armor'){
			$nbt = Entity::createBaseNBT($player, null, 2, 2);
			$nbt->setTag($player->namedtag->getTag("Skin"));
			$nbt->setString("playername", $player->getName());
			$fp = new FakePlayer($player->getLevel(), $nbt);
			$fp->setNameTagAlwaysVisible(true);
			$fp->spawnToAll();
			$player->sendMessage(TF::AQUA . 'A fake player has been spawned in!');
			if($args[0] != 'armor') return true;
			$this->giveArmor($fp);
		} else {
			$player->sendMessage($this->usageMessage);
		}
		return true;
	}

	public function giveArmor(FakePlayer $fp){
		$fp->getArmorInventory()->setContents([
			Item::get(ItemIds::DIAMOND_HELMET),
			Item::get(ItemIds::DIAMOND_CHESTPLATE),
			Item::get(ItemIds::DIAMOND_LEGGINGS),
			Item::get(ItemIds::DIAMOND_BOOTS)
		]);
	}

}
