# aws-dashboard

A PHP web app to view dashboards and their metrics of your AWS account by using the `GetMetricWidgetImage` API from AWS CloudWatch.

The Docker image of the app can be found [here](https://hub.docker.com/r/sakthivelmk/aws-dashboard/).

**Note:** The user must have the following permissions to call the API services: `"cloudwatch:ListDashboards"`, `"cloudwatch:GetDashboard"` and `"cloudwatch:GetMetricWidgetImage"`.

**Warning:** Use of the GetMetricWidgetImage API will incur additional costs to your AWS account.
