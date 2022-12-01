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
  projctsMaturityChart();
} );

function projctsMaturityChart() {

  const ctx = document.getElementById('projctsMaturityChart').getContext('2d');

  const labels = project_months;
  const data = {
    labels: labels,
    datasets: [
      {
        label: 'Sandbox',
        data: project_sandbox,
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgb(255, 99, 132)',
        fill: true
      },
      {
        label: 'Incubating',
        data: project_incubating,
        borderColor: 'rgb(255, 159, 64)',
        backgroundColor: 'rgb(255, 159, 64)',
        fill: true
      },
      {
        label: 'Graduated',
        data: project_graduated,
        borderColor: 'rgb(75, 192, 192)',
        backgroundColor: 'rgb(75, 192, 192)',
        fill: true
      },
      {
        label: 'Archived',
        data: project_archived,
        borderColor: '#747474',
        backgroundColor: '#747474',
        fill: true
      }
    ]
  };

  Chart.defaults.font.size = 16;
  Chart.defaults.font.family = 'Clarity City';

  const config = {
    type: 'line',
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
          position: 'top'
        },
        tooltip: {
          mode: 'index'
        },
      },
      interaction: {
        mode: 'nearest',
        axis: 'x',
        intersect: false
      },
      pointRadius: 0,
      scales: {
        y: {
          stacked: true,
          title: {
            display: true,
            text: 'CNCF Project Count'
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
