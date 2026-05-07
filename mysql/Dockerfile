FROM mysql:8.0

# Copy init SQL script into the entrypoint directory
COPY init.sql /docker-entrypoint-initdb.d/01-init.sql

EXPOSE 3306
