<?php

/**
 *
 * MMP""MM""YMM               .M"""bgd
 * P'   MM   `7              ,MI    "Y
 *      MM  .gP"Ya   ,6"Yb.  `MMb.   `7MMpdMAo.  ,pW"Wq.   ,pW"Wq.`7MMpMMMb.
 *      MM ,M'   Yb 8)   MM    `YMMNq. MM   `Wb 6W'   `Wb 6W'   `Wb MM    MM
 *      MM 8M""""""  ,pm9MM  .     `MM MM    M8 8M     M8 8M     M8 MM    MM
 *      MM YM.    , 8M   MM  Mb     dM MM   ,AP YA.   ,A9 YA.   ,A9 MM    MM
 *    .JMML.`Mbmmd' `Moo9^Yo.P"Ybmmd"  MMbmmd'   `Ybmd9'   `Ybmd9'.JMML  JMML.
 *                                     MM
 *                                   .JMML.
 * This file is part of TeaSpoon.
 *
 * TeaSpoon is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TeaSpoon is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with TeaSpoon.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author CortexPE
 * @link https://CortexPE.xyz
 *
 */

declare(strict_types = 1);

namespace CortexPE\entity\mob;

use pocketmine\entity\Animal;
use pocketmine\level\Level;
use pocketmine\nbt\tag\{
	ByteTag, CompoundTag
};

class Bat extends Animal {

	public const TAG_IS_RESTING = "isResting";

	public const NETWORK_ID = self::BAT;

	public $width = 0.5;
	public $height = 0.9;
	protected $age = 0;

	protected $isResting = false;

	public function initEntity(CompoundTag $nbt): void{
		if(!$nbt->hasTag(self::TAG_IS_RESTING, ByteTag::class)){
			$nbt->setByte(self::TAG_IS_RESTING, 0);
		}
		$this->isResting = boolval($nbt->getByte(self::TAG_IS_RESTING));
		$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_RESTING, $this->isResting);
		$this->setMaxHealth(6);

		parent::initEntity($nbt);
	}

	public function saveNBT() : CompoundTag{
		$nbt = parent::saveNBT();
		$nbt->setByte(self::TAG_IS_RESTING, intval($resting));
		return $nbt;
	}

	public function isResting(): bool{
		return $this->isResting;
	}

	public function getName(): string{
		return "Bat";
	}

	public function setResting(bool $resting){
		if($this->isResting !== $resting) {
			$this->isResting = $resting;
			$this->setDataFlag(self::DATA_FLAGS, self::DATA_FLAG_RESTING, $this->isResting);
		}
	}

	public function onUpdate(int $currentTick): bool{
		if($this->age > 1200){
			$this->kill();
		}

		return parent::onUpdate($currentTick);
	}
}
