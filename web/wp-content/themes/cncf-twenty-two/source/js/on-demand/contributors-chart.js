/** // phpcs:ignoreFile
 * Contributors chart code
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
  contributorsChart();
} );

function contributorsChart() {

  const ctx = document.getElementById('contributorsChart').getContext('2d');

  const labels = contributors_months;
  const data = {
    labels: labels,
    datasets: [
      {
        label: 'Contributors',
        data: contributors_counts,
        borderColor: '#0175e4',
        backgroundColor: '#0175e4',
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
          display: false
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
            text: 'CNCF Project Contributors'
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
