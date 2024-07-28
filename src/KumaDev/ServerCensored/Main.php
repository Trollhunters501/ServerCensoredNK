<?php

declare(strict_types=1);

namespace KumaDev\ServerCensored;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    /**
     * Event listener untuk PlayerChatEvent.
     *
     * @param PlayerChatEvent $event
     * @return void
     */
    public function onPlayerChat(PlayerChatEvent $event): void {
        $message = $event->getMessage();
        
        // Pattern untuk mendeteksi nama server dan domain
        $pattern = '/\b(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}\b/';
        
        // Gantikan semua domain yang terdeteksi dengan bintang
        if (preg_match($pattern, $message)) {
            $message = preg_replace($pattern, str_repeat('*', strlen($message)), $message);
            $event->setMessage($message);
        }
    }
}