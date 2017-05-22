# EVStation PHP

[![Build Status](https://travis-ci.org/johnathanmiller/EVStation-PHP.svg?branch=master)](https://travis-ci.org/johnathanmiller/EVStation-PHP)

PHP API wrapper for locating electric vehicle charging stations on NREL.
National Renewable Energy Laboratory (NREL) API v1: https://developer.nrel.gov
Get your API Key at https://developer.nrel.gov/signup/

## Rate Limiting
https://developer.nrel.gov/docs/rate-limits/

## Installation
Download evstation-php from GitHub or install using Composer
```
composer require johnathanmiller/evstation-php
```
Import into namespace environment
```php
use JohnathanMiller\EVStation\EVStation;
```
or include into your project using the require function
```php
require 'EVStation.php';
```
**Instantiate EVStation**
You'll need to pass in two arguments into EVStation. The first parameter is expecting an API key to make successful requests and the second parameter is used to format the request, `json` or `xml`.
```php
$evStation = new EVStation('YOUR_API_KEY', 'json');
```

## Examples
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