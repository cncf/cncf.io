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
			for (let i = 0; i < peopleObjLen; i++) {
				const latLng = new google.maps.LatLng( peopleObj[i]['lat'], peopleObj[i]['lng'] );
				const marker = new google.maps.Marker(
					{
						position: latLng,
						map: map,
				}
					);
				marker.addListener(
					"click",
					() => {
						infowindow.close();
						infowindow.setContent( peopleObj[i]['name'] );
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
