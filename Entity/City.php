<?php

namespace astrid\WeatherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="astrid\WeatherBundle\Repository\CityRepository")
 * @UniqueEntity(
 *     fields={"name"},
 *     message="Oops, this city is already in our system, try to add another one!"
 * )
 */
class City
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="OWAId", type="integer", nullable=true, unique=true)
     */
    private $owaId;

    /**
     * @var int
     *
     * @ORM\Column(name="latitude", type="integer", nullable=true)
     */
    private $latitude;

    /**
     * @var int
     *
     * @ORM\Column(name="longitude", type="integer", nullable=true)
     */
    private $longitude;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set oWAId
     *
     * @param integer $oWAId
     *
     * @return City
     */
    public function setOwaId($owaId)
    {
        $this->owaId = $owaId;

        return $this;
    }

    /**
     * Get oWAId
     *
     * @return int
     */
    public function getOwaId()
    {
        return $this->owaId;
    }

    /**
     * Set latitude
     *
     * @param integer $latitude
     *
     * @return City
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return int
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param integer $longitude
     *
     * @return City
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return int
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}

