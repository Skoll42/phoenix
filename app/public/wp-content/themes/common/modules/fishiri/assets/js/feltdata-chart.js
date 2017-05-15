(function ($) {
    var widgetData = window['feltWidgetData'];
    $(document).ready(function() {
        showChart("#pieChart", widgetData);
    });

    function showChart(selector) {
        var chartSelector = selector;
        if($(chartSelector).length) {
            var ctx = $(chartSelector);
            var data = {
                labels: widgetData.types,
                datasets: [
                    {
                        data: widgetData.amount,
                        backgroundColor: [
                            "#BBBBBB",
                            "#7FABCF"
                        ],
                        hoverBackgroundColor: [
                            "#BBBBBB",
                            "#7FABCF"
                        ],
                        borderColor: "transparent",
                        borderWidth: "0"
                    }]
            };
            var pieChart = new Chart(ctx, {
                type: 'pie',
                data: data,
                options: {
                    legend: {
                        display: false
                    },
                    animation: false,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var datasetLabel = data.labels[tooltipItem.index] || 'Other';
                                var label = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                return datasetLabel + ': ' + 'kr ' + label.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                            }
                        }
                    }
                }
            });
        }
    }
})(jQuery);