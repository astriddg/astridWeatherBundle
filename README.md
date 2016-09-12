# astridWeatherBundle

A Symfony project created in August 2016.

## Installation of astridWeatherBundle

Clone or download this file. Then add the follwing to your `composer.json` file :
```
        "doctrine/doctrine-fixtures-bundle": "~2.3",
        "symfony/assetic-bundle": "^2.7.1"
```

Then go on your terminal, position yourself in your application root file and enter `composer update`. 

add the following to your AppKernel:
`new astrid\WeatherBundle\astridWeatherBundle(),`

Add the following to your file `routing.yml` in app/config:
```
astrid_weather:
    resource: "@astridWeatherBundle/Resources/config/routing.yml"
    prefix:   /
```
As well as the following in your config.yml:
```
assetic:
  debug:          '%kernel.debug%'
  use_controller: '%kernel.debug%'
```

Input the following in your command line once in the bundle:
`php bin/console doctrine:schema:update --force`
then `php bin/console doctrine:fixtures:load`.

You are now ready to use this app. 
