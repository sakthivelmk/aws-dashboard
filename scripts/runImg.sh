eval $(aws ecr get-login --no-include-email)
docker run --name aws-dashboard -d -p 8080:80 042524953207.dkr.ecr.eu-west-1.amazonaws.com/aws-dashboard:latest