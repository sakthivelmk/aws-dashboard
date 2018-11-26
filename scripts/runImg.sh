eval $(aws ecr get-login --region eu-west-1 --no-include-email)
docker run --name aws-dashboard -d -p 80:80 042524953207.dkr.ecr.eu-west-1.amazonaws.com/aws-dashboard:latest