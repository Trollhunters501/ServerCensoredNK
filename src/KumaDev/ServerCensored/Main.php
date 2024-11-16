<?php

declare(strict_types=1);

namespace KumaDev\ServerCensored;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Server;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    private function isOpAllowed(string $playerName): bool {
        return $this->getConfig()->get("allow-op", false) && Server::getInstance()->isOp($playerName);
    }

    public function onPlayerChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $exemptedDomains = $this->getConfig()->get("unblocked-servers", []);
        $pattern = '/\b(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}\b/';
        
        if ($this->isOpAllowed($player->getName())) {
            return;
        }

        if (preg_match($pattern, $message)) {
            preg_match_all($pattern, $message, $matches);
            foreach ($matches[0] as $domain) {
                if (!in_array($domain, $exemptedDomains)) {
                    $message = str_replace($domain, str_repeat('*', strlen($domain)), $message);
                }
            }
            $event->setMessage($message);
        }
    }
}