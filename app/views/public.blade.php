<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Статистика пабликов</title>
	<script language="javascript" type="text/javascript" src="flot/jquery.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script type="text/javascript">

	Highcharts.setOptions({
		lang: {
			loading: 'Загрузка...',
			resetZoom: 'Убрать приближение',
		},
	});
	$(function () {
        $('#container').highcharts({
            chart: {
                zoomType: 'x'
            },
            title: {
                text: 'Зависимость числа лайков от времени, прошедшего с публикации'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Выделите область, чтобы приблизить' :
                    'Используйте 2 пальца, чтобы приблизить'
            },
            xAxis: {
            	labels: {
                    formatter: function() {
                    	val = this.value;
                        var nval = Math.round(val / 60);
                        var hours = Math.floor(nval / 60);
                        var minutes = Math.floor(nval % 60);
	   					if (hours == 0)
	 				   		return minutes + " мин. <br>назад";
	 				   	else
	 				   		return hours + " ч. " + minutes + " м. <br>назад";
                    }
                },
                min: 0,
                //minRange: 60 * 1000 // 60 seconds
            },
            yAxis: {
                title: {
                    text: 'Количество лайков'
                },
                min: 0,
            },
            legend: {
                enabled: false
            },
            plotOptions: {
               	series: {
	                marker: {
	                    radius: 3
	                },
	                lineWidth: 1,
	                tooltip: {
			            useHTML: true,
			            headerFormat: '',
			            pointFormat: '<span style="color: {series.color}">Лайки: </span>' +
			            '<span style="text-align: right"><b>{point.y} штук</b></span><br>' + 
			            '<span style="color: {series.color}">Время: </span>' +
			            '<span style="text-align: right"><b>{point.x} секунд</b></span>',
			        },
	            },
	            
            },
    
            series: [{
                type: 'spline',
                name: 'Лайки от времени с момента публикации',
                data: [
                	@foreach($dots as $dot)
   					[
                		{{ $dot['time_diff'] }},
                		{{ $dot['likes_count']}}
					],
		    		@endforeach
                ],
                marker: {
                    symbol: 'square'
                },
            }],
        });
    });
    

	</script>

</head>
<body>
	<h1>Статистика паблика <a href="http://vk.com/public{{$caption}}"> public{{ $caption }} </a></h1>
	<div id="content">
		<div id="container" style="min-width: 310px; height: 500px; margin: 0 auto"></div>

		<div class="demo-container">
			<div id="placeholder" style="width:1000px;height:500px"></div>
		</div>


	</div>

</body>
</html>
