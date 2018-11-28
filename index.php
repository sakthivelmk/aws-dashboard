<!doctype html>

<html lang="en">
<head>
<meta charset="utf-8">
<title>AWS Dashboard</title>
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
	type="text/javascript"></script>
</head>

<body>
  <header>
    <div id="title_div">
	   <h1 class="centre">AWS Cloudwatch Dashboard</h1>
    </div>
  </header>
    <div id="datetime_wrapper">    
      <div id="datetime_div">
        <input type="text" name="startdatetime" id="startdatetime" value="" placeholder="Select time range" style="width:18em"> 
         <!-- - 
        <input type="datetime-local" name="enddatetime" id="enddatetime" required> -->
        <input type="submit" name="submit" id="datatime_submit" title="Refresh" value="&#x21BB;" style="font-size: 1em; padding: 0.3em 0.5em;">        
      </div>
    </div>
    <div id="main_wrapper">
  <div id="dashboards" class="class1">
    <span>Dashboards</span>
    <br>
    <ul>
      
    </ul>

  </div>

  <div id="metrics" class="class1">
    <span>Metrics</span>
    <br>
    <div id="metrics_innerdiv">
      
    </div>

  </div>

  

  <div id="graphs_div" class="class1">
  </div>
</div>

<div id="preloader_div">
  <div id="preloader" class="centre"></div>
</div>

	<script type="text/javascript">

    var tmpData;

    function getWidgetImage(metric){
      
      if ($(metric).prop('checked')){

        $(metric).parent().addClass("selected_met");

        var metric_num = metric.val().slice(6);
        // console.log(metric);

        //add datetime
        var datetime = $('#startdatetime').val();
        // var enddatetime = $('#enddatetime').val();
        if (datetime!="") {
          var datetime_arr = datetime.split(" - ");
          var startdatetime = datetime_arr[0].replace(" ", "T");
          var enddatetime = datetime_arr[1].replace(" ", "T");
          tmpData.widgets[metric_num].properties.start = startdatetime;
          tmpData.widgets[metric_num].properties.end = enddatetime;
        } else {
          tmpData.widgets[metric_num].properties.start = "-PT3H";
          tmpData.widgets[metric_num].properties.end = "P0D";
        }

        var mw = JSON.stringify(tmpData.widgets[metric_num].properties);
        // var mw = tmpData.widgets[metric_num].properties;
        // console.log(tmpData.widgets[metric_num].properties);

        $.get("apiRequest.php?t=getMWI&mw="+mw, function(responseTxt, statusTxt, xhr){
          if(statusTxt == "success")
            $("#graphs_div").append($("<img src="+responseTxt+" id='graph"+metric_num+"'>"));
         
          if(statusTxt == "error")
            console.log("Error: " + xhr.status + ": " + xhr.statusText);
        });
      }
      else{

        $(metric).parent().removeClass("selected_met");

        var metric_num = metric.val().slice(6);
        var element = document.getElementById("graph"+metric_num);
        element.parentNode.removeChild(element);
      }

    };

    function getMetrics(dash){

        $("#dashboards li").removeClass("selected_dash");
        $("#"+dash).addClass("selected_dash");

        $.get("apiRequest.php?t=listDM&d="+dash, function(responseTxt, statusTxt, xhr){
          if(statusTxt == "success")
            // console.log(responseTxt);
            tmpData = JSON.parse(responseTxt);
            // console.log(tmpData.widgets);

            //remove exixting metrics list
            $("#metrics div").html("");
            // clear previously loaded graphs
            $("#graphs_div").html("");

            if (tmpData.widgets.length==0) {
              $("#metrics div").append("0 results");
            } else {
              for (var key in tmpData.widgets) {
                // console.log(tmpData.widgets[key].properties.metrics.toString());
                var metric = tmpData.widgets[key].properties.metrics.toString();
                $("#metrics div").append($("<span><input type='checkbox' name='metric"+key+"' value='metric"+key+"' id='metric"+key+"' onclick=getWidgetImage($(this))><label for='metric"+key+"'>"+metric+"</label></span>"));
              }
            }  
                    
          if(statusTxt == "error")
            console.log("Error: " + xhr.status + ": " + xhr.statusText);
        });
      };

  	$(document).ready(function(){

      //preloader
      $(document).ajaxStart(function(){
          $("#preloader_div").show();
      });
      $(document).ajaxComplete(function(){
          $("#preloader_div").hide();
      });

      //List dashboards
  		$.get("apiRequest.php?t=listD", function(responseTxt, statusTxt, xhr){
        if(statusTxt == "success")
          // console.log(responseTxt);
          $.each(responseTxt.split(","), function( index, value ) {
            // console.log( index + ": " + value );
            $("#dashboards ul").append($("<li id='"+value+"' onclick=getMetrics('"+value+"')></li>").text(value));
          });

            			
        if(statusTxt == "error")
          console.log("Error: " + xhr.status + ": " + xhr.statusText);
    	});

  		$("#datatime_submit").click(function(){
  			
            var checked_metrics = [];
            var met_div = document.getElementById("metrics");
            var input_items = met_div.getElementsByTagName("input");
            $.each($("#metrics div input"), function(){
              checked_metrics.push($(this).prop('checked')?$(this):"");
              // console.log("checked_metrics");
            });
            checked_metrics = checked_metrics.filter(String);
            // console.log(checked_metrics);

              // clear previously loaded graphs
              $("#graphs_div").html("");

            if (checked_metrics.length!=0) {
              $.each($(checked_metrics), function(){
                // console.log($(this));
                getWidgetImage($(this));
              })

  			}
		});
	});

  </script>
  <script type="text/javascript">
$(function() {

  $('input[name="startdatetime"]').daterangepicker({
    // ranges: {
    //     'Today': [moment(), moment()],
    //     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //     'This Month': [moment().startOf('month'), moment().endOf('month')],
    //     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    // },
      // showDropdowns: true,
      timePicker: true,
      timePicker24Hour: true,
      autoUpdateInput: false,
      opens: "left",
      locale: {
          cancelLabel: 'Clear',
          format: 'YYYY-MM-DD HH:mm'
      }
  });

  $('input[name="startdatetime"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm'));
      $("#datatime_submit").click();
  });

  $('input[name="startdatetime"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $("#datatime_submit").click();
  });

});
</script>
</body>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</html>