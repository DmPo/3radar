function initMap() {


    $(document).ready(function () {
        var uluru = {lat: 48.6372521, lng: 30.0169495};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: uluru,
            scrollwheel: false,
        });

        $.get("/api/campaigns_markers", function (data) {

            for (var i = 0; i < data.length; i++) {
                if (parseFloat(data[i].lat)) {
                    var marker = new google.maps.Marker({
                        position: {lat: parseFloat(data[i].lat), lng: parseFloat(data[i].lng)},
                        map: map,
                        title: data[i].major_name
                    });
                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            window.location = '#' + data[i].id;
                            $('.panel').removeClass('active-panel');
                            $('#' + data[i].id).addClass('active-panel');
                        }
                    })(marker, i));
                }

            }
        });
    });


}