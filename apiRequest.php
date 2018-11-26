<?php

   require 'aws_php_sdk/aws-autoloader.php';

   use Aws\CloudWatch\CloudWatchClient;
   
    $client = new CloudWatchClient([
        'region' => 'eu-west-1',
        'version' => 'latest',
        'credentials' => array(
                            'key'    => getenv('AWS_ACCESS_KEY_ID'),
                            'secret' => getenv('AWS_SECRET_ACCESS_KEY')
                        ),
        // 'profile' => 'default'
    ]);

   $result = $client->getDashboard([
    'DashboardName' => 'test', // REQUIRED
]);

    function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

  $type = test_input($_GET['t']);
  // $type = 'getMWI';

  switch ($type) {
    case 'listD':
      //List available dashboards
      $result = $client->listDashboards();
      foreach ($result['DashboardEntries'] as $inner_array) {
        $dashboards[] = $inner_array['DashboardName'];
        // $dash .= "<li><a >".$inner_array['DashboardName']."</a></li>";
      }
      echo(implode(",",$dashboards));
      // echo $dash;
      break;

    case 'listDM':
      //Get dashboard details and list metrics
      $dash = test_input($_GET['d']);
      $result = $client->getDashboard([
        'DashboardName' => $dash
      ]);
      // $widgets = json_decode($result['DashboardBody'], true)['widgets'];
      // print_r(json_decode($result['DashboardBody'], true));
      print_r($result['DashboardBody']);
      // foreach ($widgets as $widget) {
        
      // }
      break;

    case 'getMWI':
      //Get MWI
      $mw = htmlspecialchars_decode(test_input($_GET['mw']));
      // var_dump($mw);
      
      // $mw = '{
      //   "metrics": [
      //   [ "AWS/EC2", "CPUUtilization", "InstanceId", "i-0d50cfb94ed042683", { "stat": "Average", "id": "m0r0",  "label": "Webserver-test" } ]
      //   ],
      //   "title": "CPU Utilization Average",
      //   "copilot": true,
      //   "view": "timeSeries",
      //   "stacked": true,
      //   "width": 1200,
      //   "height": 400,
      //   "start": "'.$startdate.'",
      //   "end": "'.$enddate.'"
      //   }';

      // $mw = {"view":"timeSeries","stacked":true,"metrics":[["AWS/EC2","CPUUtilization","InstanceId","i-0d50cfb94ed042683"]],"region":"eu-west-1"};

      $params = [
        'MetricWidget' => $mw
        ];
  
      $result = $client->getMetricWidgetImage($params);
      
      echo "data:image/png;base64,".base64_encode($result['MetricWidgetImage']);

      break;
    
    default:
      # code...
      break;
  }

   

   
   
?>