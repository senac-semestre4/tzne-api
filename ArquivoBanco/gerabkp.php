<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

If(shell_exec("mysqldump -uroot -pL@@la280789 -R --opt BD_teste2 > BD_teste2.sql")){
echo "bkp";
}
else{
echo"erro";
}

?>
