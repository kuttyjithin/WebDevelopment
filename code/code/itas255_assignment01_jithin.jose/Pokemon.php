<?php
require_once ('Character.php');
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-09-09
 * Time: 10:52 AM
 */

abstract class Pokemon extends Character
{


    protected $weight;
    protected $hP;
    protected $type;

    /**
     * Pokemon constructor.
     * @param $name
     * @param $image
     * @param $weight
     * @param $hP
     * @param $latitude
     * @param $longitude
     * @param $type
     */
    public function __construct($name, $image, $weight, $hP, $latitude, $longitude,  $type)
    {
        parent::__construct($name, $image, $latitude, $longitude);
        $this->weight = $weight;
        $this->hP = $hP;
        $this->type = $type;
    }






    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getHP()
    {
        return $this->hP;
    }

    /**
     * @param mixed $hP
     */
    public function setHP($hP)
    {
        $this->hP = $hP;
    }



    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function attack(Pokemon $poke)
    {
      $poke->hP= $poke->hP - $this->getDamage();
    }

     abstract function getDamage();

    public function __toString()
    {
      return parent::__toString().

             "<br>Weight: ".$this->weight.

               "<br>type: ".$this->type."<br><br>";
    }

    /*public function getJSON()
    {
        // this should return a String that looks like
        // {"lat":  49.159720,"long":  -123.907773,"name": "Paras","image": "paras.png" }

        return '{"lat": '. $this->getLat().
                ',"long": '.$this->getLong().
            ',"name": "'.$this->getName().
            '","image": "'.$this->getImage().
            '"}';
    }*/
}