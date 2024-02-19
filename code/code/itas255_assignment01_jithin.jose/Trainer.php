<?php
require_once ('Character.php');
require_once ('World.php');
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-09-09
 * Time: 11:48 AM
 */
require_once ('Pokemon.php');
class Trainer extends Character
{
    protected $pokedex=array();


    /**
     * Trainer constructor.
     * @param array $pokedex
     * @param $name
     */
    public function __construct($name, $image, $lat, $long)
    {
        parent::__construct($name, $image, $lat, $long);

    }

    public function add($poke)
    {
        $this->pokedex[] = $poke;

    }
   public function setPokemon($pokes=array())
    {

        //$this->pokedex[]=$pokes;
        foreach ($pokes as $poke)
        {
            $this->pokedex[]=$poke;
        }

    }



    public function getPokemon()
    {
        return $this->pokedex;
    }



    public function printALL()
    {
        foreach ($this->pokedex as $pokes)
        {
            echo "$pokes";
        }
    }
    public function remove()
    {
        $key = array_search($this, $this->pokedex) ;
        unset($this->pokedex[$key]);
    }
    public function attackALL()
    {
        foreach ($this->pokedex as $pokee)
        {
            $pokee->attack();
        }
    }
    public function getJSON()
    {
        World::getInstance()->getJSON();
    }


}