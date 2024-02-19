<?php
/**r
 * Ceated by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-09-09
 * Time: 11:29 AM
 */
require_once ("Pokemon.php");
class Bulbasaur extends Pokemon
{
    public function __construct( $weight, $hP, $latitude, $longitude)
    {
        parent::__construct( "Bulbasaur", "bulbasaur.png", $weight, $hP, $latitude, $longitude,"grass" );
    }

    public function getDamage()
    {
        return $this->getWeight()*0.3;
    }

    public function attack(Pokemon $poke)
    {
        parent::attack($poke);
    }



}

?>