<?php

namespace astrid\WeatherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cachedweather
 *
 * @ORM\Table(name="cachedweather")
 * @ORM\Entity(repositoryClass="astrid\WeatherBundle\Repository\CachedweatherRepository")
 */
class CachedWeather
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="astrid\WeatherBundle\Entity\City")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetimetz")
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="conditions", type="text")
     */
    private $conditions;

    /**
     * @var int
     *
     * @ORM\Column(name="temperature", type="integer")
     */
    private $temperature;  

    /**
     * @var int
     *
     * @ORM\Column(name="humidity", type="integer")
     */
    private $humidity;

    /**
     * @var int
     *
     * @ORM\Column(name="day", type="string", nullable = false)
     */
    private $day;  

    /**
     * @var int
     *
     * @ORM\Column(name="date", type="datetime", nullable = true)
     */
    private $date;  

    public function __construct() {
        $this->creationDate = new \DateTime();
    }

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
     * Set city
     *
     * @param \stdClass $city
     *
     * @return Cachedweather
     */
    public function setCity(City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \stdClass
     */
    public function getCity()
    {
        return $this->city;
    }


    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Cachedweather
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Cachedweather
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return CachedWeather
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set temperature
     *
     * @param integer $temperature
     *
     * @return CachedWeather
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return integer
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set humidity
     *
     * @param integer $humidity
     *
     * @return CachedWeather
     */
    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;

        return $this;
    }

    /**
     * Get humidity
     *
     * @return integer
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * Set day
     *
     * @param integer $day
     *
     * @return CachedWeather
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CachedWeather
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
