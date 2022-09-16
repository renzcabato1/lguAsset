@extends('layouts.header')

@section('content')
<div class="main-content">
    <section class="section">
      <div class="row ">
        <div class="col-xl-3 col-lg-6">
          <div class="card l-bg-green">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-list"></i></div>
              <div class="card-content">
                <h4 class="card-title">Assets</h4>
                <span>{{count($inventories)}}</span>
               
                <p class="mb-0 text-sm">
                  as of <span class="col-white">{{(date('M d, Y'))}}</span> 
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card l-bg-cyan">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-check"></i></div>
              <div class="card-content">
                <h4 class="card-title">Available Assets</h4>
                <span>{{count($active_inventories)}}</span>
            
                <p class="mb-0 text-sm">
                  <span class="mr-2"></span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card l-bg-purple">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-paper-plane"></i></div>
              <div class="card-content">
                <h4 class="card-title">Deployed Assets</h4>
                <span>{{count($deployed_inventories)}}</span>
               
                <p class="mb-0 text-sm">
                  <span class="mr-2"></span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card l-bg-orange">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-wrench"></i></div>
              <div class="card-content">
                <h4 class="card-title">Decommissioned Assets</h4>
                <span>0</span>
                <p class="mb-0 text-sm">
                  <span class="mr-2"></span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
          <div class="card">
            <div class="card-header">
              <h4>Asset per Category</h4>
            </div>
            <div class="card-body">
              <div class="recent-report__chart">
                <div id="barChart"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
          <div class="card">
            <div class="card-header">
              <h4>Asset Allocation Per Department</h4>
            </div>
            <div class="card-body">
              <div class="recent-report__chart">
                <div id="donutChart"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

@endsection
@section('footer')
  {{-- <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script> --}}
  <script type="text/javascript">
   
    var categories = {!! json_encode($categories->toArray()) !!};
 
     // console.log(categories);
 
   
    function barChart() 
    {
   // Themes begin
   am4core.useTheme(am4themes_animated);
   // Themes end
 
 
 
   var chart = am4core.create("barChart", am4charts.XYChart);
   chart.scrollbarX = new am4core.Scrollbar();
 
   for(var i=0;i<categories.length;i++)
   {
       var dataChart = {};
       var invetories = categories[i].inventories;
       // console.log(invetories);
       dataChart.category = categories[i].category_name;
       dataChart.count = invetories.length;
       chart.data[i] = dataChart;
   }
 
   var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
   categoryAxis.dataFields.category = "category";
   categoryAxis.renderer.grid.template.location = 0;
   categoryAxis.renderer.minGridDistance = 30;
   categoryAxis.renderer.labels.template.horizontalCenter = "right";
   categoryAxis.renderer.labels.template.verticalCenter = "middle";
   categoryAxis.renderer.labels.template.rotation = 270;
   categoryAxis.tooltip.disabled = true;
   categoryAxis.renderer.minHeight = 110;
   categoryAxis.renderer.labels.template.fill = am4core.color("#9aa0ac");
 
   var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
   valueAxis.renderer.minWidth = 50;
   valueAxis.renderer.labels.template.fill = am4core.color("#9aa0ac");
 
   // Create series
   var series = chart.series.push(new am4charts.ColumnSeries());
   series.sequencedInterpolation = true;
   series.dataFields.valueY = "count";
   series.dataFields.categoryX = "category";
   series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
   series.columns.template.strokeWidth = 0;
 
 
   series.tooltip.pointerOrientation = "vertical";
 
   series.columns.template.column.cornerRadiusTopLeft = 10;
   series.columns.template.column.cornerRadiusTopRight = 10;
   series.columns.template.column.fillOpacity = 0.8;
 
   // on hover, make corner radiuses bigger
   let hoverState = series.columns.template.column.states.create("hover");
   hoverState.properties.cornerRadiusTopLeft = 0;
   hoverState.properties.cornerRadiusTopRight = 0;
   hoverState.properties.fillOpacity = 1;
 
   series.columns.template.adapter.add("fill", (fill, target) => {
     return chart.colors.getIndex(target.dataItem.index);
   })
 
   // Cursor
   chart.cursor = new am4charts.XYCursor();




   am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("donutChart", am4charts.PieChart);

// Add data
chart.data = [{
  "Department": "Web Developer",
  "litres": 501.9
}, {
  "Department": "Czech Republic",
  "litres": 301.9
}, {
  "Department": "Ireland",
  "litres": 201.1
}, {
  "Department": "Germany",
  "litres": 165.8
}, {
  "Department": "Australia",
  "litres": 139.9
}, {
  "Department": "Austria",
  "litres": 128.3
}, {
  "Department": "UK",
  "litres": 99
}, {
  "Department": "Belgium",
  "litres": 60
}, {
  "Department": "The Netherlands",
  "litres": 50
}];

// Set inner radius
chart.innerRadius = am4core.percent(50);

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "Department";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.labels.template.fill = am4core.color("#9aa0ac");

// This creates initial animationf
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;
   }

   function donutChart() {
    alert('renz');
// Themes begin

}
   </script>
     <!-- General JS Scripts -->
     <script src="{{ asset('assets/js/app.min.js') }}"></script>
     <script src="{{ asset('assets/bundles/amcharts4/core.js') }}"></script>
     <script src="{{ asset('assets/bundles/amcharts4/charts.js') }}"></script>
     <script src="{{ asset('assets/bundles/amcharts4/animated.js') }}"></script>
     <script src="{{ asset('assets/bundles/amcharts4/worldLow.js') }}"></script>
     <script src="{{ asset('assets/bundles/amcharts4/maps.js') }}"></script>
       <!-- Page Specific JS File -->
     <script src="{{ asset('assets/js/page/chart-amchart.js') }}"></script>
   
@endsection
