/**
 * Modal window
 *
 * Based on https://a11y.nicolas-hoffmann.net/modal/.
 *
 * @package WordPress
 * @since 1.0.0
 */

// @phpcs:disable PEAR.Functions.FunctionCallSignature.Indent

	jQuery( document ).ready(
	function( $ ) {
		// Initialize and add the map.
		let map;

		async function initMap() {
			// Request needed libraries.
			const { Map } = await google.maps.importLibrary( "maps" );
			const { AdvancedMarkerView } = await google.maps.importLibrary( "marker" );
			const infowindow = new google.maps.InfoWindow();

			map = new Map(
				document.getElementById( "map" ),
				{
					zoom: 2,
					center: new google.maps.LatLng( 20.312269132769966, 6.947682816594525 ),
					mapId: "DEMO_MAP_ID",
			}
				);

			const peopleObj = JSON.parse( people );
			const peopleObjLen = peopleObj.length;
			const min = .999;
			const max = 1.001;
			for (let i = 0; i < peopleObjLen; i++) {

				// adds some randomness to the positioning so that markers on same city don't overlap.
				let lat = peopleObj[i]['lat'] * (Math.random() * (max - min) + min);
				let lng = peopleObj[i]['lng'] * (Math.random() * (max - min) + min);
				
				const latLng = new google.maps.LatLng( lat, lng );

				const marker = new google.maps.Marker(
					{
						position: latLng,
						map: map,
						icon: '/wp-content/themes/cncf-twenty-two/images/person.svg',
					}
					);
				const popup = '<a href="/people/ambassadors/?p=' + peopleObj[i]['slug'] + '">' + peopleObj[i]['name'] + '</a>';
				marker.addListener(
					"click",
					() => {
						infowindow.close();
						infowindow.setContent( popup );
						infowindow.open(
						{
							anchor: marker,
							map,
						}
						);
				}
					);
			}
		}

		initMap();
	}
	);
