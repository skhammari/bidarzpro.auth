#!/bin/sh

echo "Running php on docker bidarz-auth"
docker exec bidarz-auth php "$@"