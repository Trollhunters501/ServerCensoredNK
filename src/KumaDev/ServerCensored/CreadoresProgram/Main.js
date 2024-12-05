let config;
function enable(){
    let filconf = manager.getFile("ServerCensoredNK", "config.yml");
    if(!filconf.exists()){
        let escritor = new java.io.FileWriter(filconf);
        escritor.write(require("./resources/config.yml"));
        escritor.close();
    }
    config = manager.createConfig(filconf, 2);
}
script.addEventListener("PlayerChatEvent", function(event){
    let player = event.getPlayer();
    let message = event.getMessage();
    let exeptedDomains = config.getStringList("unblocked-servers");
    let pattern = /\b(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}\b/;
    if(player.isOp()) return;
    if(pattern.test(message)){
        let matches = message.match(pattern);
        if(matches){
            matches.forEach(function(domain){
                if(!exeptedDomains.contains(domain)){
                    let regex = new RegExp(domain, 'g');
                    message = message.replace(regex, "*".repeat(domain.length));
                }
            });
        }
        event.setMessage(message);
    }
});