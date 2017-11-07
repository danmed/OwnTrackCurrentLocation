<?PHP
include "mapconfig.inc.php";
$lmlocation = mysqli_fetch_assoc($lm_result);
$dmlocation = mysqli_fetch_assoc($dm_result);

$lauraaddress = getAddress($lmlocation['latitude'],$lmlocation['longitude']);
$danaddress = getAddress($dmlocation['latitude'],$dmlocation['longitude']);

$lauraaddress = str_replace("'","",$lauraaddress);
$danaddress = str_replace("'","",$danaddress);

function getAddress($latitude,$longitude){
    if(!empty($latitude) && !empty($longitude)){
        //Send request and receive json data by address
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=false&key=AIzaSyBgon2jUSapL72eT9rzOUVl9bu88ginvXU'); 
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        //Get address from json data
        $address = ($status=="OK")?$output->results[1]->formatted_address:'';
        //Return address of the given latitude and longitude
        if(!empty($address)){
            return $address;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script> 
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script> 
<script type="text/javascript"> 
    $(document).ready(function() { initialize(); });

    function initialize() {
        var map_options = {
            center: new google.maps.LatLng(<?PHP echo $dmlocation['latitude'];?>,<?PHP echo $dmlocation['longitude'];?>),
            zoom: 5,
            mapTypeId: google.maps.MapTypeId.HYBRID
        };

        var google_map = new google.maps.Map(document.getElementById("map_canvas"), map_options);

        var info_window = new google.maps.InfoWindow({
            content: 'loading'
        });

        var t = [];
        var x = [];
        var y = [];
	var p = [];
        var h = [];

        t.push('DAN');
        x.push(<?PHP echo $dmlocation['latitude'];?>);
        y.push(<?PHP echo $dmlocation['longitude'];?>);
	p.push('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
        h.push('<p><strong>Dan</strong><br><?PHP echo $dmlocation['dt']; ?><br><?PHP echo $danaddress; ?><br><a href=\"http://web.danmed.co.uk/maps/dan\">History</a></p>');

        t.push('LAURA');
        x.push(<?PHP echo $lmlocation['latitude'];?>);
        y.push(<?PHP echo $lmlocation['longitude'];?>);
	p.push('http://maps.google.com/mapfiles/ms/icons/pink-dot.png');
        h.push('<p><strong>Laura</strong><br><?PHP echo $lmlocation['dt']; ?><br><?PHP echo $lauraaddress; ?></p><br><a href=\"http://web.danmed.co.uk/maps/laura\">History</a></p>');
    
        var i = 0;
        for ( item in t ) {
            var m = new google.maps.Marker({
                map:       google_map,
                animation: google.maps.Animation.DROP,
                title:     t[i],
                position:  new google.maps.LatLng(x[i],y[i]),
		icon : p[i],
                html:  h[i]
            });

            google.maps.event.addListener(m, 'click', function() {
                info_window.setContent(this.html);
                info_window.open(google_map, this);
            });
            i++;
        }
    }
</script> 
<center><h1>Current Locations</h1>
<div id="map_canvas" style="width:800px;height:600px;">Google Map</div> 
