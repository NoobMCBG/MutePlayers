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

class MuteCommands extends Command {

    public function __construct(Freeze $plugin) {
        $this->plugin = $plugin;
        parent::__construct("mute", "Mute Players", \null, ["m"]);
        $this->setPermission("mute.command");
    }

    public function getPlugin(){
    	return $this->plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args){
        if(!isset($args[0])){
            $sender->sendMessage("§cUsage: §7/mute <player>");
            return true;
        }
        $p = $this->getPlugin()->getServer()->getPlayerByPrefix($args[0]);
        if($this->getPlugin()->getConfig()->get("mute-no-online") == true){
            if(!$p instanceof Player){
            	$this->getPlugin()->mute->set(strtolower($p->getName()), true);
                $this->getPlugin()->mute->save();
                $sender->sendMessage(str_replace(["{line}", "{player}", "&"], ["\n", $p->getName(), "§"], strval($this->getPlugin()->getConfig()->get("msg-mute-successfully"))));
            	return true;
            }
        }else{
            $sender->sendMessage(str_replace(["{line}", "{player}", "&"], ["\n", $p->getName(), "§"], strval($this->getPlugin()->getConfig()->get("player-not-online"))));  
        }
    }
}