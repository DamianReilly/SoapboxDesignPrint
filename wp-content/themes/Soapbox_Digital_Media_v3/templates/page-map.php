<section id="con">           
            <!-- 
                You need to include this script on any page that has a Google Map.
                When using Google Maps on your own site you MUST signup for your own API key at:
                    https://developers.google.com/maps/documentation/javascript/tutorial#api_key
                After your sign up replace the key in the URL below or paste in the new script tag that Google provides.
            -->
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
            
            <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script type="text/javascript">
function initialize() {
    var secheltLoc = new google.maps.LatLng(55.8580, -4.2590),
         markers,
            myMapOptions = {
            zoom: 12,
            center: secheltLoc,
            draggable: false,
            scrollwheel: false,
            disableDefaultUI: true,
            styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}],
            mapTypeId: google.maps.MapTypeId.ROADMAP
        },
        map = new google.maps.Map(document.getElementById("map"), myMapOptions);

    function initMarkers(map, markerData) {
        var newMarkers = [],
            marker;

        for(var i=0; i<markerData.length; i++) {
            marker = new google.maps.Marker({
                map: map,
                draggable: false,
                position: markerData[i].latLng,
                visible: true,
                icon: "http://maps.google.com/mapfiles/ms/icons/orange-dot.png"
            }),
            boxText = document.createElement("div"),
            //these are the options for all infoboxes
            infoboxOptions = {
                 content: boxText,
                disableAutoPan: false,
                maxWidth: 0,
                pixelOffset: new google.maps.Size(-140, 0),
                zIndex: null,
                boxStyle: {
                    background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
                    opacity: 0.75,
                    width: "250px"
                },
                closeBoxMargin: "12px 4px 2px 2px",
                closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: false
            };

            newMarkers.push(marker);
            //define the text and style for all infoboxes
            boxText.style.cssText = "margin-top: 8px; color:#FFF; font-family:'Lato', sans-serif; font-size:12px; padding: 10px; background: #202020; border-left: 3px solid #f19a16;";
            boxText.innerHTML = markerData[i].address
            //Define the infobox
            newMarkers[i].infobox = new InfoBox(infoboxOptions);
            //Open box when page is loaded
            newMarkers[i].infobox.open(map, marker);
            //Add event listen, so infobox for marker is opened when user clicks on it.  Notice the return inside the anonymous function - this creates
            //a closure, thereby saving the state of the loop variable i for the new marker.  If we did not return the value from the inner function, 
            //the variable i in the anonymous function would always refer to the last i used, i.e., the last infobox. This pattern (or something that
            //serves the same purpose) is often needed when setting function callbacks inside a for-loop.
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    newMarkers[i].infobox.open(map, this);
                    map.panTo(markerData[i].latLng);
                }
            })(marker, i));
        }

        return newMarkers;
    }

    //here the call to initMarkers() is made with the necessary data for each marker.  All markers are then returned as an array into the markers variable
    markers = initMarkers(map, [
        { latLng: new google.maps.LatLng(55.824842, -4.286256), address: "Soapbox Digital Media - Glasgow"},
        { latLng: new google.maps.LatLng(55.884307, -4.280374), address: "Soapbox Design & Print - Glasgow North" },
        { latLng: new google.maps.LatLng(55.839673, -4.424948), address: "Soapbox Design Media - Paisley" },
        { latLng: new google.maps.LatLng(55.844431, -4.262137), address: "Soapbox Design & Print - Glasgow South" }
    ]);

    google.maps.event.addDomListener(window, 'resize', initialize);
    google.maps.event.addDomListener(window, 'load', initialize)
}

</script>
<script type="text/javascript"> 
window.onload = function() { 
   initialize(); 
} 
</script> 
            <div id="map"></div>
</section>