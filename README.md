# EVStation PHP

[![Build Status](https://travis-ci.org/johnathanmiller/EVStation-PHP.svg?branch=master)](https://travis-ci.org/johnathanmiller/EVStation-PHP)

PHP API wrapper for locating electric vehicle charging stations on NREL.
National Renewable Energy Laboratory (NREL) API v1: https://developer.nrel.gov
Get your API Key at https://developer.nrel.gov/signup/

## Installation
You can install evstation-php with Composer
```
composer require johnathanmiller/evstation-php
```

## Examples

```php
use JohnathanMiller\EVStation\EVStation;

$evStation = new EVStation('YOUR_API_KEY');
```

### Get All Stations
```php
$evStation->getAll(['zip' => 98004], 10);
```
### Get Station by ID
```php
$evStation->get(123);
```
### Nearest Stations
```php
$evStation->nearest(['location' => 'Bellevue, WA'], 10, 0);
```
### Stations Nearby Route
```php
$evStation->nearbyRoute(['route' => 'LINESTRING(-74.0 40.7, -87.63 41.87, -104.98 39.76)']);
```
### Last Updated Date
```php
$evStation->lastUpdated();
```