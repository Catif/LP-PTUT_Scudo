FROM node:18

# Create app directory
WORKDIR /app

# apt update + FFmpeg install
RUN apt-get update
RUN apt install ffmpeg -y

# Install dependencies
COPY package*.json ./
RUN npm install

# Bundle app source
COPY . .

CMD [ "npm", "start" ]