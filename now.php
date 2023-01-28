<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

$username = $_GET['username'] ?? null; // todo if no username, send back Rick Astley
$limit = $_GET['limit'] ?? 1;

$apiKey = $_ENV['LASTFMKEY'];


if (!$username)
{
    $content = "<p class='recent-played-track'>🎧 <a href='https://www.last.fm/music/Rick+Astley/_/Never+Gonna+Give+You+Up'>Never Gunna Give You Up by Rick Astley</a></p>";
    echo json_encode(['content' => $content]);
    return;
}

$res = json_decode(file_get_contents("https://ws.audioscrobbler.com/2.0/?method=user.getRecentTracks&user=$username&api_key=$apiKey&format=json&limit=$limit"));

$formattedTracks = implode('', array_map(function($track) {
    return sprintf('<p class="recent-played-track">🎧 <a href="%s">%s by %s</a></p>', $track->url, $track->name, $track->artist->{'#text'});
}, array_slice($res->recenttracks->track, 0, $limit)));

echo json_encode(['content' => $formattedTracks]);
