<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dynamic Bar Charts using Google Charts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body class="bg-secondary">

    <header class="text-center p-4 text-white bg-dark">
        <h1>Dynamic Bar Charts Using AJAX in Laravel 2020</h1>
    </header>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
         
            </div>
            <div class="col-md-3">
                <select name="year" id="year" class="form-control">
                    <option value="">Select Year</option>
                    @foreach($year_list as $row)
                        <option value="{{$row->year}}">{{$row->year}}</option>
                    @endforeach
                    {{-- <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option> --}}
                </select>
            </div>
        </div>
        <div style="margin-top: 150px;"></div>
        <div class="panel-body">
                <div id="chart_div" style="width: 100%; height: 600px;"></div>
        </div>
    
    </div>


    <script src="http://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {
            'packages': ['corechart', 'bar']
        });

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawMonthlyChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawMonthlyChart(chart_data, chart_main_title) {
            let jsonData = chart_data;
            // Create the data table.
            let data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Profit');

            $.each(jsonData, (i, jsonData) => {

                let month = jsonData.month;
                let profit = parseFloat($.trim(jsonData.profit));
                data.addRows([
                    [month, profit]
                ]);
            }); 

            // Set chart options
            var options = {
                // 'title': 'Check Monthly Profit',
                title: chart_main_title,
                hAxis: {
                    title: "Months"
                },
                vAxis: {
                    title: "Profit"
                },
                colors: ['black'],
                
            chartArea: {
                width: '50%',
                height: '80%'
            }
            }
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }


        function load_monthly_data(year, title) {
            const temp_title = title + ' ' + year;
            $.ajax({
                url: 'chart/fetch_data',
                method:"POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    year:year
                },
                dataType: "JSON",
                success:function(data) {
                    drawMonthlyChart(data, temp_title);
                } 
            });
            console.log(`Year: ${year}`);
        }

    </script>

    <script>
    
        $(document).ready(function() {
            $('#year').change(function() {
                var year = $(this).val();
                if(year != '') {
                    load_monthly_data(year, 'Monthlly Data for:');
                }
            });
        });
    </script>
</body>
</html>
