
<?php

if(!set_time_limit(0))
{
    echo 'Couldnt set maxtime';
    die();
}

class Daemon
{
    private $pidfile = 'pid.lock';
    private $savedpid = false;
    private $starttime;

    public function __construct($command = '')
    {
        $this->starttime = microtime(true);
        $this->savedpid = $this->getSavedPID();

        if($this->isDaemon())
        {            
            while($this->isDaemon())
            {   
                $data = date('d.m.y H:i:s',time()).' - I am  running for '.abs($this->starttime - microtime(true)).'s now'.PHP_EOL;
                file_put_contents('alivelog.txt',$data);

                require 'daemon-execute-code.php';

                sleep(1);
            }
        }

        if(!$this->checkAlive())
        {
            echo 'Init new daemon'.PHP_EOL;
            $this->startDaemon();
        }else {
            echo 'Daemon is alive'.PHP_EOL;
        }
    }

    public function isDaemon()
    {
        if(($this->savedpid == 'startdaemon' && $this->checkAlive()) || ($this->savedpid == getmypid()))
        {
            $this->setSavedPID(getmypid());
            return true;
        }

        return false;
    }

    public function checkAlive()
    {
        if($this->savedpid == 'startdaemon')
        {
            echo 'New daemon is starting'.PHP_EOL;
            return true;
        }

        // bail out if pid folder doesnt exist or pid is false or pid cmd is not this daemon
        if(!file_exists("/proc/" . $this->savedpid . "") || $this->savedpid == false || !is_numeric(strpos(file_get_contents('/proc/'.$this->savedpid. '/cmdline'), basename(__FILE__))))
        {
            return false;
        }

        return true;
    }

    public function getSavedPID()
    {

        $savedpid = @file_get_contents(dirname(__FILE__) . '/' . $this->pidfile);
        $savedpid = $savedpid ? $savedpid : "false";

        return $savedpid;
    }

    private function  setSavedPID($pid)
    {
        file_put_contents(dirname(__FILE__) . '/' . $this->pidfile, $pid);
        $this->savedpid = $pid;
    }

    private function startDaemon()
    {
        $this->setSavedPID('startdaemon');
        //exec("php " . dirname(__FILE__) . "/dameon.php > /dev/null &");  
        $daemoncommand = "php " . dirname(__FILE__) . "/". basename(__FILE__). ' > /dev/null &';
        
        shell_exec($daemoncommand);
    }
}

$daemon = new Daemon();

?>