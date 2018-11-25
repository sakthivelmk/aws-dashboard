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
	   <h1 class="centre">AWS-Dashboard</h1>
    </div>
  </header>
    <div id="datetime_wrapper">    
      <div id="datetime_div">
        <!-- <form> -->
        <!-- Start:
        <input type="datetime-local" name="startdaytime" id="startdaytime" value="2018-11-15T13:00:00" required> 
        End:
        <input type="datetime-local" name="enddaytime" id="enddaytime" value="2018-11-15T19:00:00" required> -->
        <!-- From: -->
        <input type="datetime-local" name="startdaytime" id="startdaytime" required> 
        <!-- To: --> - 
        <input type="datetime-local" name="enddaytime" id="enddaytime" required>
        <input type="submit" name="submit" id="datatime_submit" title="Refresh" value="&#x21BB;" style="font-size: 1em; padding: 0.3em 0.5em;">
        <!-- </form> -->
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
  <!-- <img src="loading.gif" class="centre" width="450px"> -->
  <div id="preloader" class="centre"></div>
</div>

	<script type="text/javascript">

    var tmpData;

    // function getWidgetImageWithDatetime(metric,startdaytime,enddaytime){
      
    //   // if ($(metric).prop('checked')){
    //     // console.log(metric);
    //     var metric_num = metric.val().slice(6);
    //     // console.log(metric_num);

    //     tmpData.widgets[metric_num].properties.start = startdaytime;
    //     tmpData.widgets[metric_num].properties.end = enddaytime;
    //     var mw = JSON.stringify(tmpData.widgets[metric_num].properties);
    //     // var mw = tmpData.widgets[metric_num].properties;
    //     // console.log(tmpData);

    //     $.get("apiRequest.php?t=getMWI&mw="+mw, function(responseTxt, statusTxt, xhr){
    //       if(statusTxt == "success")
    //         // console.log(responseTxt);
    //         // $.each(responseTxt.split(","), function( index, value ) {
    //         //   // console.log( index + ": " + value );
    //         //   $("#dashboards ul").append($("<li onclick=getMetrics('"+value+"')></li>").text(value));
    //         // });
    //         // // $("#dashboards ul").append(responseTxt);
    //         $("#graphs_div").append($("<img src="+responseTxt+" id='graph"+metric_num+"'>"));
  
                    
    //       if(statusTxt == "error")
    //         console.log("Error: " + xhr.status + ": " + xhr.statusText);
    //     });
    //   // }
    //   // else{
    //   //   var metric_num = metric.value.slice(6);
    //   //   // $("#graph"+metric_num).remove();
    //   //   // var graphid = "graph"+metric_num;
    //   //   // console.log(graphid)
    //   //   var element = document.getElementById("graph"+metric_num);
    //   //   element.parentNode.removeChild(element);
    //   // }

    // };

    function getWidgetImage(metric){
      
      if ($(metric).prop('checked')){

        $(metric).parent().addClass("selected_met");

        var metric_num = metric.val().slice(6);
        // console.log(metric);

        //add datetime
        var startdaytime = $('#startdaytime').val();
        var enddaytime = $('#enddaytime').val();
        if (startdaytime!=""&&enddaytime!="") {
          tmpData.widgets[metric_num].properties.start = startdaytime;
          tmpData.widgets[metric_num].properties.end = enddaytime;
        }

        var mw = JSON.stringify(tmpData.widgets[metric_num].properties);
        // var mw = tmpData.widgets[metric_num].properties;
        // console.log(tmpData.widgets[metric_num].properties);

        $.get("apiRequest.php?t=getMWI&mw="+mw, function(responseTxt, statusTxt, xhr){
          if(statusTxt == "success")
            // console.log(responseTxt);
            // $.each(responseTxt.split(","), function( index, value ) {
            //   // console.log( index + ": " + value );
            //   $("#dashboards ul").append($("<li onclick=getMetrics('"+value+"')></li>").text(value));
            // });
            // // $("#dashboards ul").append(responseTxt);
            $("#graphs_div").append($("<img src="+responseTxt+" id='graph"+metric_num+"'>"));
  
                    
          if(statusTxt == "error")
            console.log("Error: " + xhr.status + ": " + xhr.statusText);
        });
      }
      else{

        $(metric).parent().removeClass("selected_met");

        var metric_num = metric.val().slice(6);
        // $("#graph"+metric_num).remove();
        // var graphid = "graph"+metric_num;
        // console.log(graphid)
        var element = document.getElementById("graph"+metric_num);
        element.parentNode.removeChild(element);
      }

    };

    function getMetrics(dash){
        // console.log("hi");
        // var dash = $(this).html();

        $("#dashboards li").removeClass("selected_dash");
        $("#"+dash).addClass("selected_dash");

        $.get("apiRequest.php?t=listDM&d="+dash, function(responseTxt, statusTxt, xhr){
          if(statusTxt == "success")
            // console.log(responseTxt);
            tmpData = JSON.parse(responseTxt);
            // var formattedJson = JSON.stringify(tmpData, null, '\t');
            // console.log(tmpData.widgets);
            // console.log(formattedJson);

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
              // $("#dashboards ul").append(responseTxt);
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
          // $("#dashboards ul").append(responseTxt);

            			
        if(statusTxt == "error")
          console.log("Error: " + xhr.status + ": " + xhr.statusText);
    	});

      

      // $("#dashboards li").click(function(event){
      //   // event.preventDefault();
      //   console.log("hi");
      //   var dash = $(this).html();
      //   $.get("apiRequest.php?t=listDM&d="+dash, function(responseTxt, statusTxt, xhr){
      //     if(statusTxt == "success")
      //       console.log(responseTxt);
      //       // $.each(responseTxt.split(","), function( index, value ) {
      //       //   console.log( index + ": " + value );
      //       // });
      //       // $("#dashboards ul").append(responseTxt);
  
                    
      //     if(statusTxt == "error")
      //       console.log("Error: " + xhr.status + ": " + xhr.statusText);
      //   });

      // });


  		$("#datatime_submit").click(function(){
  			
        // $.each($("#metrics div input"), function(){
        //         console.log($(this));
        //         getWidgetImage($(this));
        //       })
  				// var startdaytime = $('#startdaytime').val();
  				// var enddaytime = $('#enddaytime').val();

  				// if (startdaytime!=""&&enddaytime!="") {

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

      //         // for (var met in checked_metrics) {
      //         //   console.log(met);
      //         //   getWidgetImageWithDatetime(met);
      //         // }
      //         $.each(checked_metrics, function(){
      //           // console.log($(this));
      //           getWidgetImageWithDatetime($(this),startdaytime,enddaytime);
      //         })
      //       }

  				// $.get("getMetricWidgetImage.php?s="+startdaytime+"&e="+enddaytime, function(responseTxt, statusTxt, xhr){
      //   			if(statusTxt == "success")
      //       			// alert("External content loaded successfully!");
      //       			console.log(responseTxt);
      //       			// $("#graph").attr("src", responseTxt);
      //   			if(statusTxt == "error")
      //       			alert("Error: " + xhr.status + ": " + xhr.statusText);
    		// 	});

  			} 
        // else {
  			// 	alert('Fields empty!');
  			// }
		});

      // function sendAjaxRequest(type,variables){
      //   $.get("apiRequest.php?t="+type)
      // }


	});

  </script>
</body>
</html>