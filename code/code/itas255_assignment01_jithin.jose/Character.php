<?php
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-09-16
 * Time: 11:00 AM
 */
require_once ('World.php');

abstract class Character
{

    protected $name;
    protected $lat;
    protected $image;
    protected $long;

    /**
     * Character constructor.
     * @param $name
     * @param $lat
     * @param $image
     * @param $long
     */
    public function __construct($name, $image, $lat, $long)
    {
        $this->name = $name;
        $this->lat = (float)$lat;
        $this->image = $image;
        $this->long = (float)$long;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * @param mixed $long
     */
    public function setLong($long)
    {
        $this->long = $long;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    /*public function getJSON()
    {
        World::getInstance()->getJSON();
    }*/

    public function __toString()
    {
        return "<br>Name: ".$this->name.
            "<br>Image: ".$this->image.
            "<br>HP: ".$this->lat.
            "<br>Longitude: ".$this->long.
             "<br><br>";
    }
    public function getJSON()
    {
        // this should return a String that looks like
        // {"lat":  49.159720,"long":  -123.907773,"name": "Paras","image": "paras.png" }

        return '{"lat": '. $this->getLat().
            ',"long": '.$this->getLong().
            ',"name": "'.$this->getName().
            '","image": "'.$this->getImage().
            '"}';
    }


}