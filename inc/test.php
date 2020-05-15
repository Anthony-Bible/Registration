<?php



/**
* @Param int $min_ms Minimum amount of time in milliseconds that it should take
* to calculate the hashes
*/
function getOptimalBcryptCostParameter($min_ms = 250) {
    for ($i = 4; $i < 31; $i++) {
        $options = [ 'cost' => $i];
        $time_start =now();// microtime(true);
        password_hash("rasmuslerdorf", PASSWORD_DEFAULT, $options);
        $time_end = now();//microtime(true);
        if (($time_end - $time_start) * 1000 > $min_ms) {
            return $i;
        }
        else{
        	echo "it is higher than".$i;
        }
    }
}
echo getOptimalBcryptCostParameter(); // prints 12 in my case

?>