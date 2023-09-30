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
        borderColor: 'rgb(10 178 178)',
        backgroundColor: 'rgb(10 178 178)',
        fill: true
      },
      {
        label: 'Incubating',
        data: project_incubating,
        borderColor: 'rgb(240 188 0)',
        backgroundColor: 'rgb(240 188 0)',
        fill: true
      },
      {
        label: 'Graduated',
        data: project_graduated,
        borderColor: 'rgb(193 96 220)',
        backgroundColor: 'rgb(193 96 220)',
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
  Chart.defaults.font.weight = 600;
  Chart.defaults.color = '#000';
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
