#!/bin/bash

# AirDrop Viral App - Development Setup Script
# This script sets up the complete development environment

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 AirDrop Viral App - Development Setup${NC}"
echo "======================================"

# Check for required dependencies
echo -e "\n${YELLOW}Checking dependencies...${NC}"

if ! command -v docker &> /dev/null; then
    echo -e "${RED}❌ Docker is not installed. Please install Docker first.${NC}"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}❌ Docker Compose is not installed. Please install Docker Compose first.${NC}"
    exit 1
fi

echo -e "${GREEN}✅ All dependencies found!${NC}"

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    echo -e "\n${YELLOW}Creating .env file...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✅ .env file created${NC}"
else
    echo -e "\n${GREEN}✅ .env file already exists${NC}"
fi

# Create backend .env if needed
if [ ! -f airdrop-viral-app/backend/.env ]; then
    echo -e "\n${YELLOW}Creating backend .env file...${NC}"
    cp .env airdrop-viral-app/backend/.env
    echo -e "${GREEN}✅ Backend .env file created${NC}"
fi

# Build Docker containers
echo -e "\n${YELLOW}Building Docker containers...${NC}"
docker-compose build

# Start containers
echo -e "\n${YELLOW}Starting Docker containers...${NC}"
docker-compose up -d

# Wait for database to be ready
echo -e "\n${YELLOW}Waiting for database to be ready...${NC}"
sleep 10

# Install Composer dependencies
echo -e "\n${YELLOW}Installing Composer dependencies...${NC}"
docker-compose exec -T app composer install

# Install NPM dependencies
echo -e "\n${YELLOW}Installing NPM dependencies...${NC}"
docker-compose exec -T app npm install

# Generate application key
echo -e "\n${YELLOW}Generating application key...${NC}"
docker-compose exec -T app php artisan key:generate

# Run migrations
echo -e "\n${YELLOW}Running database migrations...${NC}"
docker-compose exec -T app php artisan migrate --force

# Seed database (optional)
read -p "Do you want to seed the database with sample data? (y/N) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo -e "\n${YELLOW}Seeding database...${NC}"
    docker-compose exec -T app php artisan db:seed
fi

# Create storage link
echo -e "\n${YELLOW}Creating storage link...${NC}"
docker-compose exec -T app php artisan storage:link

# Clear caches
echo -e "\n${YELLOW}Clearing caches...${NC}"
docker-compose exec -T app php artisan cache:clear
docker-compose exec -T app php artisan config:clear
docker-compose exec -T app php artisan view:clear

# Show status
echo -e "\n${YELLOW}Checking container status...${NC}"
docker-compose ps

echo -e "\n${GREEN}🎉 Setup complete!${NC}"
echo "======================================"
echo -e "${GREEN}Your application is ready at:${NC}"
echo -e "  Web App: ${YELLOW}http://localhost${NC}"
echo -e "  API: ${YELLOW}http://localhost/api${NC}"
echo -e "\n${GREEN}Useful commands:${NC}"
echo -e "  ${YELLOW}npm run dev${NC}     - Start development server"
echo -e "  ${YELLOW}npm run logs${NC}    - View container logs"
echo -e "  ${YELLOW}npm run shell${NC}   - Access Laravel shell"
echo -e "  ${YELLOW}npm run status${NC}  - Check container status"
echo -e "\n${GREEN}Happy coding! 🚀${NC}"