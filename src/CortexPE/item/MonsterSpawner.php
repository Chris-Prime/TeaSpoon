<?php
namespace CortexPE\item;

use pocketmine\block\BlockFactory;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use CortexPE\Main;
use CortexPE\block\MonsterSpawner as MonsterSpawnerBlock;

class MonsterSpawner extends Item {
	
	public function __construct(int $id = self::MOB_SPAWNER, int $variant = 0){
		parent::__construct($id, $variant, "Monster Spawner");

		if($variant > 0 && Main::$mobSpawnerDamageAsEID) {
			$this->setEntityName();
		}
	}

	public function getVanillaName() : string {
		return "Monster Spawner";
	}

	public function setEntityName() : void {
		$path = Entity::getKnownEntityTypes()[$this->meta] ?? "";
		$name = $this->camelCase2Spaces(array_values(array_slice(explode("\\", $path), -1))[0]);
		if(!empty($name)) {
			$this->setCustomName($name." Spawner");
		}
	}

	private function camelCase2Spaces(string $string) : string {
		$string = preg_replace('/(?<=\\w)(?=[A-Z])/'," $1", $string);
		return $string = trim($string); 
	}

	public function getBlock() : Block {
		return new MonsterSpawnerBlock($this->getDamage());
	}

}