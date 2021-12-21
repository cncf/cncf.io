/** // phpcs:ignoreFile
 * Annual Report 2021 JS
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
  relentlessCharts();
  AOS.init( {
    disable: 'tablet',
    duration: 500,
    easing: 'ease-in',
    once: true,
    anchorPlacement: 'bottom-bottom',
  });
} );

function relentlessCharts() {

var ctx = document.getElementById("ar21chart").getContext("2d");

var data1 = document.getElementById("data1");

var data2 = document.getElementById("data2");

var data3 = document.getElementById("data3");

var data4 = document.getElementById("data4")

var data = {
  labels: ["2016", "2017", "2018", "2019", "2020", "2021"],
  datasets: [
    {
      data: [4, 14, 32, 45, 80, 120],
      fill: true,
      borderColor: "#5C2CFF",
      backgroundColor: createDiagonalPattern('#5C2CFF'),
      borderWidth: 4
    }
  ]
};

var options = {
  responsive: true,
  maintainAspectRatio: false,
  elements: {
    point: {
      radius: 0
    }
  },
  legend: {
    display: false
  },
  interaction: {
    intersect: false
  },
  plugins: {
    legend: false
  },
  scales: {
    xAxes: [
      {
        gridLines: {
          display: false
        }
      }
    ]
  }
};

function makeActive(e){
  const active = document.querySelector('.is-selected-data');
    if(active){
    active.classList.remove('is-selected-data');
  }
   e.currentTarget.classList.add('is-selected-data');
}

function createDiagonalPattern(color = 'black') {
  // create a 10x10 px canvas for the pattern's base shape
  let shape = document.createElement('canvas')
  shape.width = 16
  shape.height = 16
  // get the context for drawing
  let c = shape.getContext('2d')
  // draw 1st line of the shape
  c.strokeStyle = color
  c.beginPath()
  c.moveTo(2, 0)
  c.lineTo(16, 14)
  c.stroke()
  // draw 2nd line of the shape
  c.beginPath()
  c.moveTo(0, 14)
  c.lineTo(2, 16)
  c.stroke()
  // create the pattern from the shape
  return c.createPattern(shape, 'repeat')
}

var ar21chart = new Chart(ctx, {
  type: "line",
  data: data,
  options: options
});

data1.addEventListener("click", function (e) {
  makeActive(e);
  data.datasets[0].data = [4, 14, 32, 45, 80, 120];
  ar21chart.update();
});

data2.addEventListener("click", function (e) {
    makeActive(e);
  data.datasets[0].data = [13989, 29697, 52837, 82896, 116388, 144587];
  ar21chart.update();
});

data3.addEventListener("click", function (e) {
    makeActive(e);
  data.datasets[0].data = [63, 170, 349, 521, 612, 733];
  ar21chart.update();
});

data4.addEventListener("click", function (e) {
   makeActive(e);
  data.datasets[0].data = [6, 32, 69, 131, 145, 162];
  ar21chart.update();
});

}
