<?php
// src/astrid/WeatherBundle/DataFixtures/ORM/LoadCity.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use astrid\WeatherBundle\Entity\City;

class LoadCity implements FixtureInterface
{
  
  public function load(ObjectManager $manager)
  {
    
    $names = array(
      array('Paris', 2988507, 49, 2),
      array('Lyon', 2996944, 46, 5),
      array('Marseille', 2995469, 43, 5),
      array('Toulouse', 2972315, 44, 1),
      array('Nice', 6454924, 44, 7),
      array('Nantes', 2990969, 47, -2),
      array('Strasbourg', 2973783, 49, 8),
      array('Montpellier', 2992166, 44, 4),
      array('Bordeaux', 3031582, 45, -1),
      array('Lille', 2998324, 51, 3),
    );

    foreach ($names as $name) {

      $city = new City();
      $city->setName($name[0]);
      $city->setOwaId($name[1]);
      $city->setLatitude($name[2]);
      $city->setLongitude($name[3]);



      $manager->persist($city);
    }


    $manager->flush();
  }
}