(function ($) {

    var widgetData = window['dockedShipsWidgetData'];
    $(document).ready(function() {
        fillLegend(widgetData);
        showChart(".doughnutChart", widgetData);
    });

    function showChart(selector) {
        if(!$(selector).length) {
            return;
        }

        $(selector).each(function () {
            var ctx = $(this);
            var data = {
                labels: widgetData.types,
                datasets: [
                    {
                        data: widgetData.amount,
                        backgroundColor: [
                            "#81B4E1",
                            "#7F83BF",
                            "#797985",
                            "#EE5C80",
                            "#C3BB2F",
                            "#E4DD4C",
                            "#F5A45C"
                        ],
                        hoverBackgroundColor: [
                            "#81B4E1",
                            "#7F83BF",
                            "#797985",
                            "#EE5C80",
                            "#C3BB2F",
                            "#E4DD4C",
                            "#F5A45C"
                        ],
                        borderColor: "transparent",
                        borderWidth: "0"
                    }]
            };
            Chart.pluginService.register({
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = 54;
                    ctx.font = fontSize + "px TitlingGothicFB Comp";
                    ctx.fillStyle = '#1177b0';
                    ctx.textBaseline = "middle";

                    var text = widgetData.total,
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            });
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    legend: {
                        display: false
                    },
                    animation: false
                }
            });
        });
    }
    function fillLegend(widgetData) {
        var html = '';
        if(widgetData.hasOwnProperty('types')) {
            for(var type in widgetData.types) {
                if(widgetData.types.hasOwnProperty(type)) {
                    html += '<li>' + widgetData.types[type] + '</li>';
                }
            }
        }
        $('.shipdata-widget .update').html(formatUpdateDate(widgetData.updated));
        $('.shipdata-widget .shipdata-list').html(html);
    }
    function formatUpdateDate(updated) {
        var dateString = updated;
        var date = new Date(dateString.replace(' ', 'T').substring(0, dateString.length-5));
        var minute = date.getUTCMinutes();
        var hour = date.getUTCHours();
        return 'Oppdatert ' + date.getDate() + '.' + ("0" + date.getMonth()+1).slice(-2) + ' kl ' + hour + '.' + minute;
    }
})(jQuery);