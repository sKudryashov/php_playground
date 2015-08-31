FROM sfera/php5-xdebug-stack:1.01
MAINTAINER s.a.kudryashov@gmail.com

RUN apt-get update -y && apt-get install --no-install-recommends -y -q curl build-essential ca-certificates git
RUN apt-get install php-pear -y && pear channel-update pear.php.net && pear upgrade pear && \
    pear channel-discover pear.phing.info && pear install --alldeps phing/phing

#Node JS part
RUN curl --silent --location https://deb.nodesource.com/setup_0.12 | sudo bash - && \
    apt-get install --yes nodejs && apt-get install --yes build-essential

RUN npm install -g bower

#gearman installation
RUN apt-get install -y libgearman7
RUN apt-get install -y php5-gearman
EXPOSE 80
EXPOSE 9000
EXPOSE 9001
EXPOSE 443
##RUN sed -i -e"s/worker_processes  1/worker_processes 5/" /etc/nginx/nginx.conf && \