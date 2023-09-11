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
  projectsAcceptedChart();
} );

function projectsAcceptedChart() {

  const ctx = document.getElementById('projectsAcceptedChart').getContext('2d');

  const data = {
    datasets: [
      {
        label: 'Sandbox',
        data: project_sandbox_accepted_dates,
        backgroundColor: chart_sandbox_background_colors
      },
      {
        label: 'Incubating',
        data: project_incubating_accepted_dates,
        backgroundColor: chart_incubating_background_colors
      },
      {
        label: 'Graduated',
        data: project_graduated_accepted_dates,
        backgroundColor: chart_graduated_background_colors
      },
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
          position: 'top'
        },
        tooltip: {
          mode: 'index'
        },
      },
      scales: {
        y: {
          title: {
            display: true,
            text: 'Projects Accepted in to CNCF'
          },
          stacked: true
        },
        x: {
          grid: {
            display: false
          },
          stacked: true
        }
      }
    }
  };
  const myChart = new Chart(ctx, config );
}
