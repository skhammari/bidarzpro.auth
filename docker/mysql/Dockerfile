FROM mysql:latest

LABEL maintainer="Mohammad Javad Hosein Pour <mjavadhpour@gmail.com>"

#####################################
# Set Timezone
#####################################

ARG TZ="+04:30"
ENV TZ ${TZ}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone && chown -R mysql:root /var/lib/mysql/
COPY my.cnf /etc/mysql/conf.d/my.cnf

RUN chmod -R 644 /etc/mysql/conf.d/my.cnf

CMD ["mysqld"]

EXPOSE 3306
