
<?php
require '../vendor/autoload.php';

$session = new SpotifyWebAPI\Session(
    '#APIKEY_NOTHING_TO_SEE',
    '#APIKEY_NOTHING_TO_SEE'
);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);
$options = [
    'limit' =>5,
];
$tracks=$api->search($_POST["music_query"],'track',$options);
//print_r(json_encode($tracks));
$tracks = $tracks->tracks->items;
$lenght = count($tracks);
$i = 0;
//print_r($tracks[$i]);
while($i < $lenght)
{
    $row = $tracks[$i];
    $album_cover = $row->album->images[2]->url;
    $album_artist = $row->album->artists[0]->name;
    $track_title = $row->name;
    $track_id = $row->id;
    echo '
    <input type="radio" name="music_results" class="music_results" id="'.$track_id.'" value="'.$track_id.'">
    <label for='.$track_id.'>
        <div class="music_results_field">
            <div class="music_results_left">
                <img src="'.$album_cover.'">
            </div>
            <div class="music_results_right">
            <span class="track_info"><b>'.$track_title.'</b> par '.$album_artist.'</span>
            </div>
        </div>
    </label>
    <br>
    ';
    $i += 1;
}
?>
