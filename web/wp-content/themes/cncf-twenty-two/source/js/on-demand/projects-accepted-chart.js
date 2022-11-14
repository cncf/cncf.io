/** // phpcs:ignoreFile
 * Project chart code
 *
 * @package WordPress
 * @since 1.0.0
 */

/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
/* eslint-disable array-callback-return */
/* eslint-disable no-var */

function ready( fn ) {
  if ( document.readyState !== "loading" ) {
    fn();
  } else {
    document.addEventListener( "DOMContentLoaded",fn );
  }
}

ready( function () {
  relentlessCharts2();
} );

function relentlessCharts2() {

  const ctx = document.getElementById('projectsAcceptedChart').getContext('2d');

  const data = {
    datasets: [
      {
        data: accepted_values,
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgb(255, 99, 132)',
      }
    ]
  };

  Chart.defaults.font.size = 16;
  Chart.defaults.font.family = 'Clarity City';

  const config = {
    type: 'bar',
    data: data,
    options: {
			layout: {
				padding: {
					top: 20,
					bottom: 20
				}
			},
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'none'
        },
        tooltip: {
          mode: 'none'
        },
      },
      scales: {
        y: {
          title: {
            display: true,
            text: 'Projects Accepted'
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      }
    }
  };
  const myChart = new Chart(ctx, config );
}
