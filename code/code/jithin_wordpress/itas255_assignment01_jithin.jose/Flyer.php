<?php
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-09-16
 * Time: 10:24 AM
 */

interface Flyer
{
    function takeOff();
    function land();
    function getFlying();
    function getSpeed();
    function getDirection();

}