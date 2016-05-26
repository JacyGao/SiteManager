<?php
$pcs = (int)$_GET['pcs'];
header("Content-Type: text/xml");

$localDir = "/home/SHARED/previews";
$cache = "{$localDir}/{$pcs}.cache";
$jpg = "{$localDir}/{$pcs}.jpg";
$gif = "{$localDir}/{$pcs}.gif";
$mp3 = "{$localDir}/{$pcs}.mp3";

$xml = simplexml_load_string("<ITEMS></ITEMS>");
$item = $xml->addChild('Item1');
$item->addChild('PCS', $pcs);
$item->addChild('Artist');
$item->addChild('Title');
$item->addChild('Content');
$item->addChild('Category');
$item->addChild('Ext');


if( file_exists($cache) )
{
    $item->addChild('File', "/previews/". basename($cache));
    echo $xml->asXML();
    exit();
}

if( file_exists($jpg) )
{
    $item->addChild('File', "/previews/". basename($jpg));
    echo $xml->asXML();
    exit();
}

if( file_exists($gif) )
{
    $item->addChild('File', "/previews/". basename($gif));
    echo $xml->asXML();
    exit();
}

if( file_exists($mp3) )
{
    $item->addChild('File', "/previews/". basename($mp3));
    echo $xml->asXML();
    exit();
}

unset($xml);

$url = "http://apps.mobivate.com/mcs/items.php?format=XML&USER=mobivate&PWD=etavibom&ITEMS={$pcs}";

$content = file_get_contents($url);


echo $content;
