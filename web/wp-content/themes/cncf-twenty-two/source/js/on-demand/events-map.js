/**
 * Events Map JS
 *
 * @package WordPress
 * @since 1.0.0
 */

// @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
// @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore
// @phpcs:disable PEAR.Functions.FunctionCallSignature.Indent

	jQuery( document ).ready(
	function( $ ) {
		// Initialize and add the map.
		let map;

		async function initMap() {
			// Request needed libraries.
			const { Map } = await google.maps.importLibrary( "maps" );
			const { AdvancedMarkerView } = await google.maps.importLibrary( "marker" );
			const infoWindow = new google.maps.InfoWindow(
				{
					content: "",
					disableAutoPan: true,
				}
			);
			map = new Map(
				document.getElementById( "map" ),
				{
					zoom: 2,
					center: new google.maps.LatLng( 20.312269132769966, 6.947682816594525 ),
					mapId: "DEMO_MAP_ID",
					zoomControl: true,
					mapTypeControl: false,
					scaleControl: false,
					streetViewControl: false,
					rotateControl: false,
					fullscreenControl: false
					}
				);

			const eventsObj = JSON.parse( events );
			const eventsObjLen = eventsObj.length;
			const min = .999;
			const max = 1.001;

			for (let i = 0; i < eventsObjLen; i++) {

				// adds some randomness to the positioning so that markers on same city don't overlap.
				let lat = eventsObj[i]['lat'] * (Math.random() * (max - min) + min);
				let lng = eventsObj[i]['lng'] * (Math.random() * (max - min) + min);

				const latLng = new google.maps.LatLng( lat, lng );

				const marker = new google.maps.Marker(
					{
						position: latLng,
						map,
						icon: eventsObj[i]['icon'],
						title: 'Select ' + eventsObj[i]['name']
					}
				);

				const popup = '<a class="map-button" title="View ' + eventsObj[i]['name'] + '" href="' + eventsObj[i]['url'] + '">' + eventsObj[i]['name'] + '</a><p class="date">' + eventsObj[i]['date'] + '</p>';
				marker.addListener(
					"click",
					() => {
						infoWindow.close();
						infoWindow.setContent( popup );
						infoWindow.open(
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
