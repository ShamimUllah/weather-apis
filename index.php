<?php 
	$google_map_api_key='AIzaSyDjApChQze5X6DqTJg6Rhr5hCJi5_IBauM';
	$api_key='bf3b269916cbe305';
	$city='kolkata.json';
	$path='http://api.wunderground.com/api/'.$api_key.'/conditions/q/CA/'.$city;

	if($_SERVER['HTTP_HOST']=='localhost')
	{
		$path=dirname('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);	
		$path=$path.'/'.$city;	
	}

	$response_json=file_get_contents($path);
	$response_arr=json_decode($response_json);

	// echo '<pre>';
	// print_r($response_arr->current_observation);
	$str='Weather : '.$response_arr->current_observation->weather.'<br>';
	$str.='Temperature : '.$response_arr->current_observation->temp_c.'&#8451;<br>';
	$str.='Wind Speed : '.$response_arr->current_observation->wind_kph.'Km/h';

?>
<!DOCTYPE html>
<html>
<head>
	<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_map_api_key; ?>"></script>
    <script>

     function initMap() {
        var myLatlng = new google.maps.LatLng(<?php echo $response_arr->current_observation->display_location->latitude; ?>, <?php echo $response_arr->current_observation->display_location->longitude; ?>);

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: myLatlng
        });

        var contentString = "<?php echo ($str); ?>";

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: "Weather Report of <?php echo ($response_arr->current_observation->display_location->full); ?>"
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }
      google.maps.event.addDomListener(window, 'load', initMap);
    </script>
	<title></title>
</head>
<body>
	 <div id="map"></div>

</body>
</html>