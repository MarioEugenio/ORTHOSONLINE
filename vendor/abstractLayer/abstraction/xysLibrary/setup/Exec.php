<?php
namespace abstraction\xysLibrary\setup;

/**
 * Created by IntelliJ IDEA.
 * User: marioeugenio
 * Date: 8/13/12
 * Time: 9:33 AM
 * To change this template use File | Settings | File Templates.
 */
class Exec
{
    public function executePHP($script){
        $cmd = "php \"" . dirname($_SERVER['SCRIPT_FILENAME']) . $script;
        exec($cmd, $out);

        return $out;
    }

    public function execute($cmd){
        exec($cmd, $out);

        return $out;
    }

    public function executeShell ($file)
    {
        return shell_exec($file);
    }
}
