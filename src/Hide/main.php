<?php

namespace Hide;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerQuitEvent;

class main extends PluginBase implements Listener{
 
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
	if(!file_exists($this->getDataFolder())){
		mkdir($this->getDataFolder(), 0744, true);
	}
	$this->hide = new Config($this->getDataFolder() ."hide.yml", Config::YAML);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) :bool{
	    switch (strtolower($command->getName())) {
		    case "hide":
		    
		    if($sender->isOp()){
		        if($this->hide->exists($sender->getName())){
		            if($sender->getName() == "Yusuke1201"){
		                $this->getServer()->broadcastMessage("§l§b管理人 §e{$sender->getName()} §6がサーバーに参加しました。");
		            }else{
		                $this->getServer()->broadcastMessage("§l§d権限者 §e{$sender->getName()} §6がサーバーに参加しました。");
		            }
				$this->hide->remove($sender->getName());
		                $this->hide->save();
		                $this->hide->reload();
		        }else{
		            if($sender->getName() == "Yusuke1201"){
		                $this->getServer()->broadcastMessage("§l§b管理人 §e{$sender->getName()} §9がサーバーを退出しました。");
		            }else{
		                $this->getServer()->broadcastMessage("§l§d権限者 §e{$sender->getName()} §9がサーバーを退出しました。");
		            }
		                $this->hide->set($sender->getName(),count($this->hide->getAll())+1);
		                $this->hide->save();
		                $this->hide->reload();
		        }
		    }else{
		        $sender->sendMessage("§cこのコマンドを実行する権限がありません");
		    }
	    }
	    return true;
    }
    
    public function onPlayerQuit(PlayerQuitEvent $event){
        if($this->hide->exists($event->getPlayer()->getName())){
            if($event->getPlayer()->getName() == "Yusuke1201"){
                $this->getServer()->broadcastMessage("§l§b管理人 §e{$event->getPlayer()->getName()} §6がサーバーに参加しました。");
	    }else{
		$this->getServer()->broadcastMessage("§l§d権限者 §e{$event->getPlayer()->getName()} §6がサーバーに参加しました。");
	    }
		$this->hide->remove($event->getPlayer()->getName());
	        $this->hide->save();
	        $this->hide->reload();
        }
    }
}
