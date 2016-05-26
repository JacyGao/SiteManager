<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 11:52 AM
 */

define('SOUTH_AFRICA',  'sa');
define('GHANA',         'gh');
define('KENYA',         'ke');
define('MALAWI',        'ma');
define('CANADA',        'ca');
define('AUSTRALIA',     'au');
define('UK',            'uk');
define('NEW_ZEALAND',   'nz');

$country = SOUTH_AFRICA;
$config['countries'][$country]['name'] = 'South Africa';
$config['countries'][$country]['currency'] = 'Rand';
$config['countries'][$country]['prefix'] = '27';
$config['countries'][$country]['min-length'] = '11';
$config['countries'][$country]['max-length'] = '12';
$config['countries'][$country]['placeholder'] = '08';
$config['countries'][$country]['example'] = '08XXXXXXX';

$country = GHANA;
$config['countries'][$country]['name'] = 'Ghana';
$config['countries'][$country]['currency'] = 'Cedi';
$config['countries'][$country]['prefix'] = '233';
$config['countries'][$country]['min-length'] = '11';
$config['countries'][$country]['max-length'] = '12';
$config['countries'][$country]['placeholder'] = '03';
$config['countries'][$country]['example'] = '03XXXXXXX';

$country = KENYA;
$config['countries'][$country]['name'] = 'Kenya';
$config['countries'][$country]['currency'] = 'KSH';
$config['countries'][$country]['prefix'] = '254';
$config['countries'][$country]['min-length'] = '11';
$config['countries'][$country]['max-length'] = '12';
$config['countries'][$country]['placeholder'] = '07';
$config['countries'][$country]['example'] = '07XXXXXXX';

$country = MALAWI;
$config['countries'][$country]['name'] = 'Malawi';
$config['countries'][$country]['currency'] = 'Kwacha';
$config['countries'][$country]['prefix'] = '265';
$config['countries'][$country]['min-length'] = '11';
$config['countries'][$country]['max-length'] = '12';
$config['countries'][$country]['placeholder'] = '02';
$config['countries'][$country]['example'] = '02XXXXXXX';

$country = CANADA;
$config['countries'][$country]['name'] = 'Canada';
$config['countries'][$country]['currency'] = 'CAD';
$config['countries'][$country]['prefix'] = '1';
$config['countries'][$country]['min-length'] = '11';
$config['countries'][$country]['max-length'] = '13';
$config['countries'][$country]['placeholder'] = '647';
$config['countries'][$country]['example'] = '647XXXXXXX';

$country = AUSTRALIA;
$config['countries'][$country]['name'] = 'Australia';
$config['countries'][$country]['currency'] = 'AUD';
$config['countries'][$country]['prefix'] = '61';
$config['countries'][$country]['min-length'] = '11';
$config['countries'][$country]['max-length'] = '11';
$config['countries'][$country]['placeholder'] = '04';
$config['countries'][$country]['example'] = '04XXXXXXXX';

$country = UK;
$config['countries'][$country]['name'] = 'United Kingdom';
$config['countries'][$country]['currency'] = 'GBP';
$config['countries'][$country]['prefix'] = '44';
$config['countries'][$country]['min-length'] = '11';
$config['countries'][$country]['max-length'] = '12';
$config['countries'][$country]['placeholder'] = '07';
$config['countries'][$country]['example'] = '07XXXXXXXX';

$country = NEW_ZEALAND;
$config['countries'][$country]['name'] = 'New Zealand';
$config['countries'][$country]['currency'] = 'NDZ';
$config['countries'][$country]['prefix'] = '64';
$config['countries'][$country]['min-length'] = '11';
$config['countries'][$country]['max-length'] = '12';
$config['countries'][$country]['placeholder'] = '02';
$config['countries'][$country]['example'] = '02XXXXXXXX';
