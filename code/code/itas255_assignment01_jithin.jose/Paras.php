<?php
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-09-09
 * Time: 11:47 AM
 */
require_once ('Pokemon.php');
class Paras extends Pokemon
{
    public function __construct( $weight, $hP, $latitude, $longitude)
    {
        parent::__construct( "Paras", "paras.png", $weight, $hP, $latitude, $longitude,"grass" );
    }

    public function attack(Pokemon $poke)
    {
        parent::attack($poke);
    }

    public function getDamage()
    {
        return $this->getWeight()*0.8;
        // TODO: Implement getDamage() method.
    }
}