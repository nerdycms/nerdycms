<?php
app::check();

class task
{
    var $key;
    var $command;
    var $pid;

    function __construct($key,$command)
    {
        $this->key = $key;
        $this->command = $command;
    }

    function run($outputFile = null)
    {
        if(!$outputFile) $outputFile = SYS_CONTENT_DIR."/lasttask.log";
        $cmd = sprintf(
            "nohup %s >> %s 2>&1 & echo $!",
            $this->command,
            $outputFile
        );
        //var_dump($this->command);
        //app::log("exec $cmd");        
        $this->pid = shell_exec($cmd);        
        file_put_contents(SYS_CONTENT_DIR."/$this->key.pid", $this->pid);
    }

   static function isRunning($key)
    {
        try {

//        if(!($pid = @file_get_contents(SYS_CONTENT_DIR."/$key.pid"))) return false;

            try {
                $pid = trim(file_get_contents(SYS_CONTENT_DIR."/$key.pid"));

                if (empty($pid)) {
                    return false;
                }

                $executed = filter_var(trim(shell_exec("ps -p $pid -o etime")), FILTER_SANITIZE_NUMBER_INT);

                if (empty($executed)) {
                    //shell_exec("kill -9 $pid");

                    return false;
                }

                return true;
            } catch(Exception $e) {
            }
        } catch (Throwable $exception) {
        }

        return true;
    }
}