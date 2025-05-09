<?php

// Author: Simon Newton

class sfu {
    function schedule() {
        return;
        if(!task::isRunning("sfu")) {
            runner::log("00000000","GO SFU -----------------------------------------------------------------------------------");
            $t = new task("sfu",ROOT."/bin/sfu -c ".NROOT."config/sfu-config.toml -cert ".SSL_PATH_PARTIAL."crt -key ".SSL_PATH_PARTIAL."key -a :2087");
            $t->run();
            runner::log("00000000", "$t->pid ---------------------------------------------------------------------------------\n");
        }
    }
    
    function run($rkey,$arg) {
        // DUMMY IMMEDIATE RUN
    }
}