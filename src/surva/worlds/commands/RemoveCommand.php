<?php
/**
 * Worlds | remove world command
 */

namespace surva\worlds\commands;

use pocketmine\command\CommandSender;
use surva\worlds\logic\WorldActions;

class RemoveCommand extends CustomCommand
{

    public function do(CommandSender $sender, array $args): bool
    {
        if (!(count($args) === 1)) {
            return false;
        }

        switch (WorldActions::unloadIfLoaded($this->getWorlds(), $args[0])) {
            case WorldActions::UNLOAD_DEFAULT:
                $sender->sendMessage($this->getWorlds()->getMessage("unload.default"));

                return true;
            case WorldActions::UNLOAD_FAILED:
                $sender->sendMessage($this->getWorlds()->getMessage("unload.failed"));

                return true;
        }

        $this->getWorlds()->delete($this->getWorlds()->getServer()->getDataPath() . "worlds/" . $args[0]);

        $sender->sendMessage($this->getWorlds()->getMessage("remove.success", ["name" => $args[0]]));

        return true;
    }

}
