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

namespace NoobMCBG\MutePlayers;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerChatEvent;
use NoobMCBG\MutePlayers\commands\MuteCommands;
use NoobMCBG\MutePlayers\commands\UnMuteCommands;

class MutePlayers extends PluginBase implements Listener {

	public static $instance;

	public static function getInstance(){
		return self::$instance;
	}

	public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $this->mute = new Config($this->getDataFolder() . "mute.yml", Config::YAML);
        $this->getServer()->getCommandMap()->register("MutePlayers", new MuteCommands($this));
        $this->getServer()->getCommandMap()->register("MutePlayers", new UnMuteCommands($this));
	}

    public function onChat(PlayerChatEvent $ev){
        $player = $ev->getPlayer();
        if($this->mute->get(strtolower($player->getName())) == true){
            $ev->cancel();
            if($this->getConfig()->getAll()["msg-mute"]["mode"] == "message"){
                $player->sendMessage(str_replace(["{line}", "{player}", "&"], ["\n", $player->getName(), "§"], strval($this->getConfig()->getAll()["msg-mute"]["msg"])));
            }
            if($this->getConfig()->getAll()["msg-mute"]["mode"] == "popup"){
                $player->sendPopup(str_replace(["{line}", "{player}", "&"], ["\n", $player->getName(), "§"], strval($this->getConfig()->getAll()["msg-mute"]["msg"])));
            }
            if($this->getConfig()->getAll()["msg-mute"]["mode"] == "title"){
                $player->addTitle(str_replace(["{line}", "{player}", "&"], ["\n", $player->getName(), "§"], strval($this->getConfig()->getAll()["msg-mute"]["msg"])));
            }
        }
    }
}