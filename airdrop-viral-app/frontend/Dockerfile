FROM node:20-alpine

WORKDIR /app

# Copy package files and install deps (none currently)
COPY package.json ./
RUN npm install --production

# Copy the rest of the source (if any)
COPY . .

# Default command just echoes build success; docker-compose overrides with npm run build
CMD ["echo", "Frontend container built successfully"] 