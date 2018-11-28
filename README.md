# aws-dashboard

A PHP web app to view dashboards and their metrics of your AWS account by using the `GetMetricWidgetImage` API from AWS CloudWatch.

The image can be used with the following command:

`$ docker run -e AWS_ACCESS_KEY_ID=𝘺𝘰𝘶𝘳_𝘢𝘸𝘴_𝘪𝘥 -e AWS_SECRET_ACCESS_KEY=𝘺𝘰𝘶𝘳_𝘢𝘸𝘴_𝘬𝘦𝘺 -d sakthivelmk/aws-dashboard`

where `𝘺𝘰𝘶𝘳_𝘢𝘸𝘴_𝘪𝘥` and `𝘺𝘰𝘶𝘳_𝘢𝘸𝘴_𝘬𝘦𝘺` are your AWS user credentials.

**Note:** The user must have the following permissions to call the API services: `"cloudwatch:ListDashboards"`, `"cloudwatch:GetDashboard"` and `"cloudwatch:GetMetricWidgetImage"`.

**Warning:** Use of the GetMetricWidgetImage API will incur additional costs to your AWS account.
