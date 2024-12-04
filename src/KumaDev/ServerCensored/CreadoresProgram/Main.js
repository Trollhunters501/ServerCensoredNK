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
});