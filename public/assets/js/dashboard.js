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
                      height: 300,
                      offsetX: -15,
                      toolbar: { show: true },
                      foreColor: "#adb0bb",
                      fontFamily: 'inherit',
                      sparkline: { enabled: false },
                  },

                  colors: ["#49BEFF", "#5D87FF"],

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
                      categories: serverData[i].monthxaxis,
                      labels: {
                          style: { cssClass: "grey--text lighten-2--text fill-color" },
                      },
                  },

                  yaxis: {
                      show: true,
                      min: 0,
                      max: serverData[i].yaxis,
                      tickAmount: 5,
                      labels: {
                          style: {
                              cssClass: "grey--text lighten-2--text fill-color",
                          },
                          formatter: function (value) {
                                  return numeral(value).format('0.0a').toUpperCase();
                              }
                          },
                      tickPositions: [0, serverData[i].yaxis * 0.2, serverData[i].yaxis * 0.4, serverData[i].yaxis * 0.6, serverData[i].yaxis * 0.8, serverData[i].yaxis],
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

  // detail Scoreboard
  var activityId = $('#scoreboard_detail_actId').text();

  $.ajax({
    url: '/chart-dashboard-detail/' + activityId,
    type: 'GET',
    dataType: 'json',
    success: function(alldata) {
        for (let i = 0; i < alldata.length; i++) {
            var chartConfig2 = {
                series: alldata[i].series,

                chart: {
                    type: "bar",
                    height: 300,
                    offsetX: -15,
                    toolbar: { show: true },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                    sparkline: { enabled: false },
                },

                colors: ["#49BEFF", "#5D87FF"],

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
                    categories: alldata[i].monthxaxis,
                    labels: {
                        style: { cssClass: "grey--text lighten-2--text fill-color" },
                    },
                },

                yaxis: {
                    show: true,
                    min: 0,
                    max: alldata[i].yaxis,
                    tickAmount: 5,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                        formatter: function (value) {
                                return numeral(value).format('0.0a').toUpperCase();
                            }
                        },
                    tickPositions: [0, alldata[i].yaxis * 0.2, alldata[i].yaxis * 0.4, alldata[i].yaxis * 0.6, alldata[i].yaxis * 0.8, alldata[i].yaxis],
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

            var initialChart = new ApexCharts(document.querySelector("#chartDashboard_" + i), chartConfig2);
            initialChart.render();
        }
    },
    error: function(error) {
        console.error('Error fetching chart data:', error);
    }
});

$.ajax({
    url: '/chart-activity-wig',
    type: 'GET',
    dataType: 'json',
    success: function(datautama) {
        for (let i = 0; i < datautama.length; i++) {
            var chartConfig3 = {
                series: datautama[i].series,

                chart: {
                    type: "bar",
                    height: 250,
                    offsetX: -15,
                    toolbar: { show: true },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                    sparkline: { enabled: false },
                },

                colors: ["#e6e3e3", "#5D87FF"],

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
                    categories: datautama[i].monthxaxis,
                    labels: {
                        style: { cssClass: "grey--text lighten-2--text fill-color" },
                    },
                },

                yaxis: {
                    show: true,
                    min: 0,
                    max: datautama[i].yaxis,
                    tickAmount: 5,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                    }
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

            var initialChart = new ApexCharts(document.querySelector("#chartActivityWIG_" + i), chartConfig3);
            initialChart.render();
        }
    },
    error: function(error) {
        console.error('Error fetching chart data:', error);
    }
});


$.ajax({
    url: '/chart-activity-ig',
    type: 'GET',
    dataType: 'json',
    success: function(datautama) {
        for (let i = 0; i < datautama.length; i++) {
            var chartConfig4 = {
                series: datautama[i].series,

                chart: {
                    type: "bar",
                    height: 250,
                    offsetX: -15,
                    toolbar: { show: true },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                    sparkline: { enabled: false },
                },

                colors: ["#e6e3e3", "#5D87FF"],

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
                    categories: datautama[i].monthxaxis,
                    labels: {
                        style: { cssClass: "grey--text lighten-2--text fill-color" },
                    },
                },

                yaxis: {
                    show: true,
                    min: 0,
                    max: datautama[i].yaxis,
                    tickAmount: 5,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                    }
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

            var initialChart = new ApexCharts(document.querySelector("#chartActivityIG_" + i), chartConfig4);
            initialChart.render();
        }
    },
    error: function(error) {
        console.error('Error fetching chart data:', error);
    }
});

  $.ajax({
    url: '/my-task-data',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      var mytask = {
        color: "#adb5bd",
        series: data.series,
        labels: ["Complete", "On Progres", "Not yet started"],
        chart: {
          width: 180,
          type: "donut",
          fontFamily: "Plus Jakarta Sans', sans-serif",
          foreColor: "#adb0bb",
        },
        plotOptions: {
          pie: {
            startAngle: 0,
            endAngle: 360,
            donut: {
              size: '75%',
            },
          },
        },
        stroke: {
          show: false,
        },
    
        dataLabels: {
          enabled: false,
        },
    
        legend: {
          show: false,
        },
        colors: ["#5D87FF", "#81b5fc", "#d2e3fa"],
    
        responsive: [
          {
            breakpoint: 991,
            options: {
              chart: {
                width: 150,
              },
            },
          },
        ],
        tooltip: {
          theme: "dark",
          fillSeriesColor: false,
        },
      };
    
      var chart = new ApexCharts(document.querySelector("#myTask"), mytask);
      chart.render();
    },
    error: function(error) {
        console.error('Error fetching mytask chart data:', error);
    }
  });

//   $.ajax({
//     url: '/dept-task-data',
//     type: 'GET',
//     dataType: 'json',
//     success: function(data) {
//     for (let i = 0; i < data.length; i++) {
//         var mytask2 = {
//             color: "#adb5bd",
//             series: data[i].series,
//             labels: ["Complete", "On Progres", "Not yet started"],
//             chart: {
//               width: 180,
//               type: "donut",
//               fontFamily: "Plus Jakarta Sans', sans-serif",
//               foreColor: "#adb0bb",
//             },
//             plotOptions: {
//               pie: {
//                 startAngle: 0,
//                 endAngle: 360,
//                 donut: {
//                   size: '75%',
//                 },
//               },
//             },
//             stroke: {
//               show: false,
//             },
        
//             dataLabels: {
//               enabled: false,
//             },
        
//             legend: {
//               show: false,
//             },
//             colors: ["#5D87FF", "#81b5fc", "#d2e3fa"],
        
//             responsive: [
//               {
//                 breakpoint: 991,
//                 options: {
//                   chart: {
//                     width: 150,
//                   },
//                 },
//               },
//             ],
//             tooltip: {
//               theme: "dark",
//               fillSeriesColor: false,
//             },
//           };
      
//           var chart = new ApexCharts(document.querySelector("#deptTask_"+i), mytask2);
//           chart.render();
//         },
//         error: function(error) {
//             console.error('Error fetching mytask chart data:', error);
//         }
//     }
//   });
  
});