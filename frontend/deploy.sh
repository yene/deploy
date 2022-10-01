#!/bin/bash
set -e

# compile on local machine or in pipeline
npm ci
npm run build
docker build -t frontend:v1 -f Dockerfile.prod .
docker run --rm -p 8081:8081 frontend:v1

# compile in docker
docker build -t frontend:v2 -f Dockerfile.multi .
docker run --rm -p 8081:8081 frontend:v2
