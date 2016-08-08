# astridWeatherBundle

A Symfony project created in August 2016.

## Installation of astridWeatherBundle

Clone or download this file, add the following to your AppKernel:
`new astrid\WeatherBundle\astridWeatherBundle(),`

Add the following to your file `routing.yml` in app/config:
```
astrid_weather:
    resource: "@astridWeatherBundle/Resources/config/routing.yml"
    prefix:   /
```

Input the following in your command line once in the bundle:
`php bin/console doctrine:schema:update --force`

