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
      print_r($result['DashboardBody']);
      break;

    case 'getMWI':
      //Get MWI
      $mw = htmlspecialchars_decode(test_input($_GET['mw']));
      // var_dump($mw);
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