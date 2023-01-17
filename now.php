<?php

require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');

use Carbon\Carbon;
use League\CommonMark\CommonMarkConverter;

$address = $_GET['address'];

$res = json_decode(file_get_contents("https://api.omg.lol/address/$address/now"));

$updated = $res->response->now->updated;
$content = $res->response->now->content;

$updatedAt = Carbon::createFromTimestamp($updated)->diffForHumans();
$content = str_replace('{last-updated}', "<span class='now_updated'>Updated $updatedAt</span>", $content);

$content = str_replace('{address}', $address, $content);

$converter = new CommonMarkConverter([
    'allow_unsafe_links' => true,
]);
// remove {omg-lol-specific-stuff}
$content = preg_replace("/{[^}]*}/", "", $content);
// remove comments
$content = preg_replace("#/\*.*?\*/#s", "", $content);

if (str_contains($content, '--- Now ---'))
{
    $content = explode('--- Now ---', $content);
    $content[0] = "<span class='now_before'>$content[0]</span>";
    $content[1] = "<span class='now_after'>$content[1]</span>";
    $content = implode("\n", $content);
}

$content = $converter->convert($content)->__toString();

header("Content-Type: application/json");
echo json_encode(['content' => $content]);
