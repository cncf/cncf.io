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
  projectMovesChart();
} );

function projectMovesChart() {

  const ctx = document.getElementById('projectMovesChart').getContext('2d');

  const data = {
    datasets: [
      {
        label: 'Incubating',
        data: project_incubating_move_dates,
        backgroundColor: moves_chart_incubating_background_colors
      },
      {
        label: 'Graduated',
        data: project_graduated_move_dates,
        backgroundColor: moves_chart_graduated_background_colors
      },
      {
        label: 'Archived',
        data: project_archived_move_dates,
        backgroundColor: moves_chart_archived_background_colors
      },
    ]
  };

  Chart.defaults.font.size = 16;
  Chart.defaults.font.weight = 600;
  Chart.defaults.color = '#000';
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
            text: 'Projects Moves into Tier'
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
