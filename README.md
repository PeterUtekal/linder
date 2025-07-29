# AirDrop Viral App 🚀

A viral social introduction app that leverages AirDrop's unique naming feature to create fun, IRL connections.

## 🏗️ Architecture & Tech Stack

### **Frontend**
- **Framework**: Vue.js 3 with Inertia.js
- **Styling**: Tailwind CSS
- **Build Tool**: Vite
- **Location**: `airdrop-viral-app/frontend/`

### **Backend**
- **Framework**: Laravel 10 (PHP 8.2+)
- **API**: RESTful JSON API
- **Location**: `airdrop-viral-app/backend/`

### **Database & Storage**
- **Primary Database**: PostgreSQL 15 (containerized)
  - Host: `localhost:5432` (development)
  - Database: `airdrop_viral`
  - User: `airdrop_user`
- **Cache/Queue**: Redis 7 (containerized)
  - Host: `localhost:6379` (development)
- **File Storage**: S3-compatible object storage (production)

### **Infrastructure**
- **Containerization**: Docker & Docker Compose
- **Web Server**: Nginx/Caddy (containerized)
- **Queue Workers**: Laravel Queue (containerized)
- **Production**: Google Cloud Run (recommended)

## 🚀 Quick Start

### Prerequisites
- Docker & Docker Compose
- Node.js 18+ (for local development)

### One-Command Setup

```bash
# Clone the repository
git clone <your-repo-url>
cd airdrop-viral-app

# Run the setup script (interactive)
npm run init

# Or manually:
cp .env.example .env
npm run fresh
```

This will:
1. Build all Docker containers
2. Install all dependencies
3. Generate application key
4. Run database migrations
5. Seed initial data

### Access the Application
- **Web App**: http://localhost
- **API**: http://localhost/api
- **Database**: `localhost:5432`
- **Redis**: `localhost:6379`

## 📝 Available Commands

All commands are simplified through npm scripts:

### Development
```bash
npm run dev          # Start containers + run Vite dev server
npm run start        # Start all containers in background
npm run stop         # Stop all containers
npm run status       # Check container status
```

### Database
```bash
npm run migrate      # Run database migrations
npm run migrate:fresh # Drop all tables and re-migrate
npm run seed         # Seed the database
npm run db:shell     # Access PostgreSQL CLI
```

### Application
```bash
npm run shell        # Access Laravel app shell
npm run tinker       # Laravel Tinker REPL
npm run queue        # Start queue worker
npm run logs         # View all container logs
npm run logs:app     # View app logs only
npm run logs:db      # View database logs only
```

### Cache & Testing
```bash
npm run cache:clear  # Clear all caches
npm run test         # Run test suite
npm run redis:cli    # Access Redis CLI
```

### Setup & Maintenance
```bash
npm run setup        # Initial setup (install deps, generate key)
npm run fresh        # Complete fresh install
npm run clean        # Remove containers and dependencies
npm run prod:build   # Build for production
```

## 🔧 Configuration

### Environment Variables

The main `.env` file in the root directory controls:
- Database credentials
- Redis configuration
- App URL and keys
- S3 storage settings

### Docker Services

All services are defined in `docker-compose.yml`:
- **web**: Nginx/Caddy server (ports 80, 443)
- **app**: Laravel PHP-FPM application
- **queue**: Laravel queue worker
- **frontend**: Vue.js build service
- **db**: PostgreSQL database
- **cache**: Redis cache/queue

## 🚢 Production Deployment

### Google Cloud Run (Recommended)

```bash
# Set your project
export PROJECT_ID=your-gcp-project-id
export REGION=us-central1

# Build and push images
docker build -t gcr.io/$PROJECT_ID/airdrop-viral-app:latest -f backend/Dockerfile .
docker push gcr.io/$PROJECT_ID/airdrop-viral-app:latest

# Deploy to Cloud Run
gcloud run deploy airdrop-viral-app \
  --image gcr.io/$PROJECT_ID/airdrop-viral-app:latest \
  --region $REGION \
  --platform managed
```

### Other Platforms
- AWS ECS/Fargate
- DigitalOcean App Platform
- Heroku with Container Registry
- Any Kubernetes cluster

## 📁 Project Structure

```
.
├── docker-compose.yml       # All services configuration
├── package.json            # Simplified npm commands
├── .env.example           # Environment template
├── README.md              # This file
├── airdrop-viral-app/     # Main application
│   ├── backend/          # Laravel API
│   └── frontend/         # Vue.js SPA
└── docker/               # Docker configurations
    └── nginx/           # Web server config
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License.
