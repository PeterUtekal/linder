# AirDrop Viral Intro App 💫

A viral social introduction app that leverages AirDrop's unique naming feature to create fun, IRL connections. Users create profiles with photos and messages, then share them via AirDrop with creative device names to spark conversations.

## 🚀 Features

- **Profile Creation**: Quick setup with photo, message, location, and contact method
- **Viral AirDrop Sharing**: Clever use of device naming for attention-grabbing shares
- **Tinder-Style Swiping**: Recipients swipe right to reveal contact info
- **QR Code Fallback**: Alternative sharing method when AirDrop isn't available
- **Analytics Dashboard**: Track views, swipes, and viral conversions
- **Mobile-First Design**: Beautiful, responsive UI optimized for smartphones

## 🛠️ Tech Stack

- **Backend**: Laravel 10 (PHP 8.2+)
- **Frontend**: Vue.js 3 + Inertia.js
- **Database**: PostgreSQL
- **Cache/Queue**: Redis
- **Storage**: S3-compatible object storage
- **Deployment**: Docker + Google Cloud Run

## 📋 Prerequisites

- Docker & Docker Compose
- Google Cloud SDK
- S3-compatible storage (AWS S3, Google Cloud Storage, etc.)
- Domain with SSL certificate

## 🏃‍♂️ Local Development

1. **Clone the repository**:
   ```bash
   git clone <your-repo-url>
   cd airdrop-viral-app
   ```

2. **Copy environment files**:
   ```bash
   cp .env.example .env
   cd backend
   cp .env.example .env
   ```

3. **Configure environment variables**:
   - Update database credentials
   - Set S3 storage credentials
   - Configure app URL

4. **Start Docker containers**:
   ```bash
   docker-compose up -d
   ```

5. **Install dependencies**:
   ```bash
   docker-compose exec app composer install
   docker-compose exec app npm install
   ```

6. **Run migrations**:
   ```bash
   docker-compose exec app php artisan migrate
   ```

7. **Build frontend assets**:
   ```bash
   docker-compose exec app npm run dev
   ```

8. **Access the app**:
   - Web: http://localhost
   - API: http://localhost/api

## 🚀 Deployment to Google Cloud Run

### 1. Build and Push Docker Images

```bash
# Set your project ID
export PROJECT_ID=your-gcp-project-id
export REGION=us-central1

# Configure Docker for Google Container Registry
gcloud auth configure-docker

# Build and push the app image
docker build -t gcr.io/$PROJECT_ID/airdrop-viral-app:latest -f backend/Dockerfile .
docker push gcr.io/$PROJECT_ID/airdrop-viral-app:latest

# Build and push the web server image
docker build -t gcr.io/$PROJECT_ID/airdrop-viral-web:latest -f docker/nginx/Dockerfile .
docker push gcr.io/$PROJECT_ID/airdrop-viral-web:latest
```

### 2. Create Cloud SQL Database

```bash
# Create PostgreSQL instance
gcloud sql instances create airdrop-viral-db \
  --database-version=POSTGRES_14 \
  --tier=db-f1-micro \
  --region=$REGION

# Create database
gcloud sql databases create airdrop_viral \
  --instance=airdrop-viral-db

# Create user
gcloud sql users create airdrop_user \
  --instance=airdrop-viral-db \
  --password=<secure-password>
```

### 3. Set up Redis (Memorystore)

```bash
gcloud redis instances create airdrop-viral-cache \
  --size=1 \
  --region=$REGION \
  --redis-version=redis_6_x
```

### 4. Configure Secrets

```bash
# Create secrets
echo -n "your-app-key" | gcloud secrets create app-key --data-file=-
echo -n "your-db-password" | gcloud secrets create db-password --data-file=-
echo -n "your-s3-key" | gcloud secrets create s3-access-key --data-file=-
echo -n "your-s3-secret" | gcloud secrets create s3-secret-key --data-file=-
```

### 5. Deploy to Cloud Run

Create `cloudrun-app.yaml`:

```yaml
apiVersion: serving.knative.dev/v1
kind: Service
metadata:
  name: airdrop-viral-app
spec:
  template:
    metadata:
      annotations:
        run.googleapis.com/cloudsql-instances: PROJECT_ID:REGION:airdrop-viral-db
        run.googleapis.com/vpc-connector: airdrop-viral-connector
    spec:
      containers:
      - image: gcr.io/PROJECT_ID/airdrop-viral-app:latest
        ports:
        - containerPort: 9000
        env:
        - name: APP_KEY
          valueFrom:
            secretKeyRef:
              name: app-key
              key: latest
        - name: DB_CONNECTION
          value: pgsql
        - name: DB_HOST
          value: /cloudsql/PROJECT_ID:REGION:airdrop-viral-db
        - name: DB_DATABASE
          value: airdrop_viral
        - name: DB_USERNAME
          value: airdrop_user
        - name: DB_PASSWORD
          valueFrom:
            secretKeyRef:
              name: db-password
              key: latest
        resources:
          limits:
            cpu: '2'
            memory: 2Gi
```

Deploy:

```bash
gcloud run deploy airdrop-viral-app \
  --image gcr.io/$PROJECT_ID/airdrop-viral-app:latest \
  --platform managed \
  --region $REGION \
  --allow-unauthenticated \
  --add-cloudsql-instances $PROJECT_ID:$REGION:airdrop-viral-db \
  --set-env-vars "APP_ENV=production,APP_DEBUG=false"
```

### 6. Set up Load Balancer with Cloud CDN

```bash
# Reserve static IP
gcloud compute addresses create airdrop-viral-ip --global

# Create backend service
gcloud compute backend-services create airdrop-viral-backend \
  --global \
  --load-balancing-scheme=EXTERNAL \
  --protocol=HTTPS

# Add Cloud Run service as backend
gcloud compute backend-services add-backend airdrop-viral-backend \
  --global \
  --network-endpoint-group=<cloud-run-neg> \
  --network-endpoint-group-region=$REGION

# Enable CDN
gcloud compute backend-services update airdrop-viral-backend \
  --global \
  --enable-cdn \
  --cache-mode=CACHE_ALL_STATIC
```

## 🔧 Production Optimizations

1. **Enable OPcache**: Already configured in Dockerfile
2. **Configure Redis**: Use for sessions, cache, and queues
3. **Set up CDN**: Cache static assets and images
4. **Enable GZIP**: Configured in Caddy
5. **Optimize images**: Consider using image optimization service

## 📊 Monitoring

1. **Set up Cloud Monitoring**:
   ```bash
   gcloud services enable monitoring.googleapis.com
   ```

2. **Create uptime checks**:
   ```bash
   gcloud monitoring uptime-check create airdrop-viral \
     --display-name="AirDrop Viral App" \
     --uri="https://your-domain.com/health"
   ```

3. **Configure alerts** for:
   - High response times
   - Error rates
   - Database connections
   - Storage usage

## 🔒 Security Considerations

1. **Environment Variables**: Never commit `.env` files
2. **CORS**: Configure allowed origins in production
3. **Rate Limiting**: Implement API rate limiting
4. **File Uploads**: Validate file types and sizes
5. **SQL Injection**: Use Laravel's query builder
6. **XSS Protection**: Enabled by default in Laravel

## 📱 Mobile App Considerations

For enhanced mobile experience:
- Add PWA manifest for installability
- Implement push notifications for matches
- Consider native app wrappers (Capacitor/React Native)

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License.