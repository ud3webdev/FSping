<?php
$i = 0;
set_time_limit(60);
for ($i = 0; $i < 59; ++$i) {
    shell_exec('/usr/bin/php /var/FSping/ping.php > /dev/null 2>&1 &');
    echo $i;
    //sleep(1);
}
echo 'Stop';
// Script end
function rutime($ru, $rus, $index) {
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}
