<?php
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-09-09
 * Time: 11:42 AM
 */
require_once ('Pokemon.php');
class Pikachu extends Pokemon
{
    public function __construct( $weight, $hP, $latitude, $longitude)
    {
        parent::__construct( "Pikachu", "pikachu.png", $weight, $hP, $latitude, $longitude,"grass" );
    }

    public function getDamage()
    {
        return $this->getWeight()*1.5;
        // TODO: Implement getDamage() method.
    }

    public function attack(Pokemon $poke)
    {
        parent::attack($poke);
    }
}