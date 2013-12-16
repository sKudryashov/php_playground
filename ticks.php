<?php
/**
 * ticks  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */
class TickHand {
    protected static $c = 1;
    public function instantiate($pew = '')
    {
        $mem_use = memory_get_usage();
        echo '<br />'.$mem_use;
        echo self::$c;
        self::$c++;
    }
}
register_tick_function(array('TickHand', 'instantiate'), '123');

declare(ticks = 2)
{
    $pew = hash('sha1', '123');
    $pew2 = strrev($pew);
    $pew3 = $pew2;
}

?>
