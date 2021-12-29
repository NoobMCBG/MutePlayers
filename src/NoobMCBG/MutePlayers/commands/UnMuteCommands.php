<?php

/*
 *   
 *   ███╗░░██╗░█████╗░░█████╗░██████╗░███╗░░░███╗░█████╗░██████╗░░██████╗░
 *   ████╗░██║██╔══██╗██╔══██╗██╔══██╗████╗░████║██╔══██╗██╔══██╗██╔════╝░
 *   ██╔██╗██║██║░░██║██║░░██║██████╦╝██╔████╔██║██║░░╚═╝██████╦╝██║░░██╗░
 *   ██║╚████║██║░░██║██║░░██║██╔══██╗██║╚██╔╝██║██║░░██╗██╔══██╗██║░░╚██╗
 *   ██║░╚███║╚█████╔╝╚█████╔╝██████╦╝██║░╚═╝░██║╚█████╔╝██████╦╝╚██████╔╝
 *   ╚═╝░░╚══╝░╚════╝░░╚════╝░╚═════╝░╚═╝░░░░░╚═╝░╚════╝░╚═════╝░░╚═════╝░
 *
 *               Copyright (C) 2021-2022 NoobMCBG
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *              (at your option) any later version.
 *
 */

declare(strict_types=1);

namespace NoobMCBG\MutePlayers\commands;

use pocketmine\Player;
use pocketmine\command\{Command, CommandSender};
use pocketmine\plugin\{Plugin, PluginBase};
use NoobMCBG\MutePlayers\MutePlayers;

class UnMuteCommands extends Command {

    public function __construct(MutePlayers $plugin) {
        $this->plugin = $plugin;
        parent::__construct("unmute", "UnMute Player", \null, ["um"]);
        $this->setPermission("unmute.command");
    }

    public function getPlugin(){
    	return $this->plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args){
        if(!isset($args[0])){
            $sender->sendMessage("§cUsage: §7/unmute <player>");
            return true;
        }
        $p = $this->getPlugin()->getServer()->getPlayerByPrefix($args[0]);
        $this->getPlugin()->mute->set(strtolower($p->getName()), false);
        $this->getPlugin()->mute->save();
        $sender->sendMessage(str_replace(["{line}", "{player}", "&"], ["\n", $p->getName(), "§"], strval($this->getPlugin()->getConfig()->get("msg-unmute-successfully"))));
    }
}