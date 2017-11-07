<!doctype html>
<head>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.40.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.40.1/mapbox-gl.css' rel='stylesheet' />
    <style>
      * { box-sizing: border-box; }
      body { text-align: center; padding: 50px; }
      h1 { font-size: 50px; }
      body { font: 20px Helvetica, sans-serif; color: #333; }
      article { display: block; text-align: left; width: 650px; margin: 0 auto; }
      a { color: #dc8100; text-decoration: none; }
      a:hover { color: #333; text-decoration: none; }
      .form-group { margin-bottom: 5px; }
      input { width: 100%; padding: 7px 5px; }
      button { padding: 7px 10px; float: right; }
      #mapBox {
          width: 100%;
          height: 600px;
      }
    </style>
</head>
<body>
    <article>
        <div class="map mapbox" id="mapBox"></div>
    </article>
    <script language="JavaScript">
        mapboxgl.accessToken = 'pk.eyJ1IjoicG13Y29tbXVuaWNhdGlvbnMiLCJhIjoiY2o4NXJudDdtMGkzejJ3bXA0YTgzaXJtbiJ9.TXHNSEROw-Wm-BhMlOPyRQ';

        // Init Mapbox
        var map = new mapboxgl.Map({
            container: 'mapBox',
            style: 'mapbox://styles/pmwcommunications/cj9pgdleo5av52rp08tekmyoj',   // Style imported from Mapbox
            center: [-1.009384,50.944801],
            zoom: 3,
            scrollZoom: false, // This is really annoying on a MBP mouse and phone.
        });

        // Add Nav Controls (optional)
        map.addControl(new mapboxgl.NavigationControl());

        // Create Marker div element in DOM. Added some simple styles (Can be done is stylesheets).
        var el    = document.createElement('div');
        el.className = 'marker';
        el.style.backgroundImage = 'url(./img/twyford-pin-40h.png)';
        el.style.width = '106px';
        el.style.height = '40px';

        // On click listener if required
        el.addEventListener('click', function() {
            window.alert('Marker Click Event');
        });

        // add marker to map
        new mapboxgl.Marker(el, {offset: [0, -20]}) // The offset is width, height. 0, 0 is center.
            .setLngLat([-1.009384,50.944801])
            .addTo(map);

        setTimeout(function() {
            map.flyTo({
                bearing: 0,
                center: [-1.009384,50.944801],
                zoom: 7,
                speed: 1,
                pitch: 60
            });
        },1500)

        // No scrolling in demo so this wont work.
        /*
        (function() {
            // Quick jQuery function to detect whether item in viewport.
            jQuery.fn.isOnScreen = function(){

                var win = jQuery(window);

                var viewport = {
                    top : win.scrollTop(),
                    left : win.scrollLeft()
                };
                viewport.right = viewport.left + win.width();
                viewport.bottom = viewport.top + win.height();

                var bounds = this.offset();
                bounds.right = bounds.left + this.outerWidth();
                bounds.bottom = bounds.top + this.outerHeight();

                return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

            };

            // Use jQuery to detect whether the map is within the viewport
            jQuery(window).scroll(function() {
                var $mapBox = jQuery('#mapBox');
                if ($mapBox.isOnScreen() === true) {
                    // Added this class so that it only runs once. There is probably a better way to do it.
                    if(!$mapBox.hasClass('active'))
                    {
                        $mapBox.addClass('active');
                        map.flyTo({
                            bearing: 0,
                            center: [-1.009384,50.944801],
                            zoom: 15,
                            speed: 1,
                            pitch: 60
                        });
                    }
                }
            });
        })(jQuery);
        */

    </script>
</body>

