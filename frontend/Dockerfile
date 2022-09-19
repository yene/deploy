FROM node:alpine
WORKDIR /app
COPY package.json ./
COPY package-lock.json ./
COPY ./ ./
RUN npm i
RUN chmod a+x /app/node_modules/.bin/react-scripts

CMD ["node", "/app/node_modules/react-scripts/bin/react-scripts.js", "start"]