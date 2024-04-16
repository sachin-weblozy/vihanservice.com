<script>
    $(document).ready(function() {
    /*======== 16. ANALYTICS - ACTIVITY CHART ========*/
    var activity = document.getElementById("tickets");
    if (activity !== null) {
        @php $adminTicketActivity = Helper::admin_ticket_activity(); @endphp
        var activityData = [
            {
            first: [
                @php 
                foreach($adminTicketActivity['createdCount'] as $createdCount){
                    echo $createdCount.',';
                } 
                @endphp
            ],
            second: [
                @php 
                foreach($adminTicketActivity['inprogressCount'] as $inprogressCount){
                    echo $inprogressCount.',';
                } 
                @endphp
            ],
            third: [
                @php 
                foreach($adminTicketActivity['solvedCount'] as $solvedCount){
                    echo $solvedCount.',';
                } 
                @endphp
            ],
            }
        ];

        var config = {
            // The type of chart we want to create
            type: "line",
            // The data for our dataset
            data: {
            labels: [
                @php 
                foreach($adminTicketActivity['last10Days'] as $dailyDate){
                    echo '"'.$dailyDate.'",';
                } 
                @endphp
            ],
            // labels: [
            //     "4 Jan",
            //     "5 Jan",
            //     "6 Jan",
            //     "7 Jan",
            //     "8 Jan",
            //     "9 Jan",
            //     "10 Jan"
            // ],
            datasets: [
                {
                    label: "New",
                    backgroundColor: "transparent",
                    borderColor: "rgba(82, 136, 255, .8)",
                    data: activityData[0].first,
                    lineTension: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255,255,255,1)",
                    pointHoverBackgroundColor: "rgba(255,255,255,1)",
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    pointHoverBorderWidth: 1
                },
                {
                    label: "InProgress",
                    backgroundColor: "transparent",
                    borderColor: "rgba(255, 199, 15, .8)",
                    data: activityData[0].second,
                    lineTension: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255,255,255,1)",
                    pointHoverBackgroundColor: "rgba(255,255,255,1)",
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    pointHoverBorderWidth: 1
                }
                ,
                {
                    label: "Solved",
                    backgroundColor: "transparent",
                    borderColor: "rgba(80, 215, 171, .8)",
                    data: activityData[0].third,
                    lineTension: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255,255,255,1)",
                    pointHoverBackgroundColor: "rgba(255,255,255,1)",
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    pointHoverBorderWidth: 1
                }
            ]
            },
            // Configuration options go here
            options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                xAxes: [
                {
                    gridLines: {
                    display: false,
                    },
                    ticks: {
                    fontColor: "#8a909d", // this here
                    },
                }
                ],
                yAxes: [
                {
                    gridLines: {
                    fontColor: "#8a909d",
                    fontFamily: "Roboto, sans-serif",
                    display: true,
                    color: "#eee",
                    zeroLineColor: "#eee"
                    },
                    ticks: {
                    // callback: function(tick, index, array) {
                    //   return (index % 2) ? "" : tick;
                    // }
                    stepSize: 2,
                    fontColor: "#8a909d",
                    fontFamily: "Roboto, sans-serif"
                    }
                }
                ]
            },
            tooltips: {
                mode: "index",
                intersect: false,
                titleFontColor: "#888",
                bodyFontColor: "#555",
                titleFontSize: 12,
                bodyFontSize: 15,
                backgroundColor: "rgba(256,256,256,0.95)",
                displayColors: true,
                xPadding: 10,
                yPadding: 7,
                borderColor: "rgba(220, 220, 220, 0.9)",
                borderWidth: 2,
                caretSize: 6,
                caretPadding: 5
            }
            }
        };

        var ctx = document.getElementById("tickets").getContext("2d");
        var myLine = new Chart(ctx, config);

        var items = document.querySelectorAll("#user-activity .nav-tabs .nav-item");
        items.forEach(function(item, index){
            item.addEventListener("click", function() {
            config.data.datasets[0].data = activityData[index].first;
            config.data.datasets[1].data = activityData[index].second;
            config.data.datasets[2].data = activityData[index].third;
            myLine.update();
            });
        });
    }



    /*======== 11. DOUGHNUT CHART ========*/
  var doughnut = document.getElementById("ticketOverview");
  @php $adminTicketOverview = Helper::admin_ticket_overview(); @endphp
  if (doughnut !== null) {
    var myDoughnutChart = new Chart(doughnut, {
      type: "doughnut",
      data: {
        labels: ["Solved", "InProgress", "Created"],
        datasets: [
          {
            label: ["Solved", "InProgress", "Created"],
            data: [
                {{ $adminTicketOverview['solvedCount'] }}, 
                {{ $adminTicketOverview['inprogressCount'] }}, 
                {{ $adminTicketOverview['createdCount'] }}
            ],
            backgroundColor: ["#50d7ab", "#f3d676", "#ed9090"],
            borderWidth: 1
            // borderColor: ['#88aaf3','#29cc97','#8061ef','#fec402']
            // hoverBorderColor: ['#88aaf3', '#29cc97', '#8061ef', '#fec402']
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        cutoutPercentage: 75,
        tooltips: {
          callbacks: {
            title: function(tooltipItem, data) {
              return "Order : " + data["labels"][tooltipItem[0]["index"]];
            },
            label: function(tooltipItem, data) {
              return data["datasets"][0]["data"][tooltipItem["index"]];
            }
          },
          titleFontColor: "#888",
          bodyFontColor: "#555",
          titleFontSize: 12,
          bodyFontSize: 14,
          backgroundColor: "rgba(256,256,256,0.95)",
          displayColors: true,
          borderColor: "rgba(220, 220, 220, 0.9)",
          borderWidth: 2
        }
      }
    });
  }
});
</script>