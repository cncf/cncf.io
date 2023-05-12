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
					zoomControl: true,
					mapTypeControl: false,
					scaleControl: false,
					streetViewControl: false,
					rotateControl: false,
					fullscreenControl: false
					}
				);

			const peopleObj = JSON.parse( people );
			const peopleObjLen = peopleObj.length;
			const min = .999;
			const max = 1.001;
			const markers = [];

			const renderer = {
				render: ({ count, position }) =>

				new google.maps.Marker({
					label: { text: String(count), color: "#fff", fontSize: "14px", fontWeight: "600", fontFamily: "Clarity City" },
					icon: {
						url: `data:image/svg+xml,%3Csvg fill='%23000' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 240 240'%3E%3Ccircle cx='120' cy='120' opacity='.7' r='110' /%3E%3C/svg%3E`,
						scaledSize: new google.maps.Size(45, 45),
					},
					position,
					// adjust zIndex to be above other markers
					zIndex: Number(google.maps.Marker.MAX_ZINDEX) + count,
				})

			};

			for (let i = 0; i < peopleObjLen; i++) {

				// adds some randomness to the positioning so that markers on same city don't overlap.
				let lat = peopleObj[i]['lat'] * (Math.random() * (max - min) + min);
				let lng = peopleObj[i]['lng'] * (Math.random() * (max - min) + min);
				
				const latLng = new google.maps.LatLng( lat, lng );

				const marker = new google.maps.Marker(
					{
						position: latLng,
						icon: '/wp-content/themes/cncf-twenty-two/images/map-marker.svg',
					}
				);

				const popup = '<button data-modal-content-id="modal-' + peopleObj[i]['id'] + '" data-modal-slug="' + peopleObj[i]['slug'] + '" data-modal-prefix-class="person" class="js-modal button-reset map-button modal-' + peopleObj[i]['slug'] + '" aria-haspopup="dialog">' + peopleObj[i]['name'] + '</button>';
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

				markers.push( marker );
			}

			new markerClusterer.MarkerClusterer({ markers, map, renderer });
		}

		initMap();
	}
	);
