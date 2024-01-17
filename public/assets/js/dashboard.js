$(function () {
  // =====================================
  // Profit
  // =====================================
  $.ajax({
      url: '/chart-data',
      type: 'GET',
      dataType: 'json',
      success: function(serverData) {
          for (let i = 0; i < serverData.length; i++) {
              var chartConfig = {
                  series: serverData[i].series,

                  chart: {
                      type: "bar",
                      height: 345,
                      offsetX: -15,
                      toolbar: { show: true },
                      foreColor: "#adb0bb",
                      fontFamily: 'inherit',
                      sparkline: { enabled: false },
                  },

                  colors: ["#5D87FF", "#49BEFF"],

                  plotOptions: {
                      bar: {
                          horizontal: false,
                          columnWidth: "35%",
                          borderRadius: [6],
                          borderRadiusApplication: 'end',
                          borderRadiusWhenStacked: 'all'
                      },
                  },

                  markers: { size: 0 },

                  dataLabels: {
                      enabled: false,
                  },

                  legend: {
                      show: false,
                  },

                  grid: {
                      borderColor: "rgba(0,0,0,0.1)",
                      strokeDashArray: 3,
                      xaxis: {
                          lines: {
                              show: false,
                          },
                      },
                  },

                  xaxis: {
                      type: "category",
                      categories: ["16/08", "17/08", "18/08", "19/08", "20/08", "21/08", "22/08", "23/08"],
                      labels: {
                          style: { cssClass: "grey--text lighten-2--text fill-color" },
                      },
                  },

                  yaxis: {
                      show: true,
                      min: 0,
                      max: 400,
                      tickAmount: 4,
                      labels: {
                          style: {
                              cssClass: "grey--text lighten-2--text fill-color",
                          },
                      },
                  },

                  stroke: {
                      show: true,
                      width: 3,
                      lineCap: "butt",
                      colors: ["transparent"],
                  },

                  tooltip: { theme: "light" },

                  responsive: [
                      {
                          breakpoint: 600,
                          options: {
                              plotOptions: {
                                  bar: {
                                      borderRadius: 3,
                                  }
                              },
                          }
                      }
                  ]
              };

              var initialChart = new ApexCharts(document.querySelector("#chart_" + i), chartConfig);
              initialChart.render();
          }
      },
      error: function(error) {
          console.error('Error fetching chart data:', error);
      }
  });
});