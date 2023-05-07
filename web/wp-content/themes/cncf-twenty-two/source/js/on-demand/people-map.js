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
		// Initialize and add the map
		let map;

		async function initMap() {
		// The location of Uluru
		const position = { lat: -25.344, lng: 131.031 };
		// Request needed libraries.
		//@ts-ignore
		const { Map } = await google.maps.importLibrary("maps");
		const { AdvancedMarkerView } = await google.maps.importLibrary("marker");

		// The map, centered at Uluru
		map = new Map(document.getElementById("map"), {
			zoom: 2,
			center: position,
			mapId: "DEMO_MAP_ID",
		});

		// The marker, positioned at Uluru
		const marker = new AdvancedMarkerView({
			map: map,
			position: position,
			title: "Uluru",
		});
		}

		initMap();
	}
	);
