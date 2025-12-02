# Docker Setup Guide for Job Portal

## Prerequisites
- Install [Docker Desktop](https://www.docker.com/products/docker-desktop)
- Stop any existing XAMPP MySQL (uses port 3306, container will use 3307)

## Quick Start

### 1. Copy environment file
```powershell
Copy-Item .env.docker .env
```

### 2. Build and start containers
```powershell
docker-compose up -d --build
```

This will create and start:
- **app** (PHP-FPM 8.2)
- **webserver** (Nginx)
- **db** (MySQL 8.0)
- **phpmyadmin** (Database UI)

### 3. Run Laravel setup inside the app container
```powershell
docker exec -it laravel-app bash
```

Inside the container:
```bash
# Generate app key
php artisan key:generate

# Run database migrations
php artisan migrate

# Create storage symlink
php artisan storage:link

# Seed database (optional)
php artisan db:seed

# Exit container
exit
```

## Access Your Application

| Service | URL | Credentials |
|---------|-----|-------------|
| **App** | http://localhost:8000 | - |
| **phpMyAdmin** | http://localhost:8080 | root / root |
| **MySQL (Host)** | 127.0.0.1:3307 | root / root |

## Common Commands

### View logs
```powershell
docker-compose logs -f app
docker-compose logs -f db
```

### Stop containers
```powershell
docker-compose down
```

### Restart containers
```powershell
docker-compose restart
```

### Access app container shell
```powershell
docker exec -it laravel-app bash
```

### Run Artisan commands
```powershell
docker exec -it laravel-app php artisan migrate
docker exec -it laravel-app php artisan tinker
```

### Rebuild after code changes
```powershell
docker-compose up -d --build
```

## Troubleshooting

### Port already in use
If port 8000 or 8080 is already in use, edit `docker-compose.yml`:
```yaml
# Change 8000:80 to 9000:80 for app
# Change 8080:80 to 9090:80 for phpmyadmin
```

### Container won't start
Check logs:
```powershell
docker-compose logs app
```

### Database connection issues
Ensure `DB_HOST=db` (not localhost) in `.env` file inside container.

### Storage permission errors
```powershell
docker exec -it laravel-app chown -R www-data:www-data /var/www/storage
docker exec -it laravel-app chmod -R 775 /var/www/storage
```

## Development Workflow

1. **Make code changes** on your host machine
2. **Changes are automatically reflected** in container (volumes are synced)
3. **Run migrations/seeders** as needed:
   ```powershell
   docker exec -it laravel-app php artisan migrate
   ```
4. **Access phpMyAdmin** to inspect database

## File Structure
- `.env` - Docker environment config (copy from `.env.docker`)
- `Dockerfile` - PHP-FPM 8.2 image with dependencies
- `docker-compose.yml` - Service orchestration (app, nginx, mysql, phpmyadmin)
- `nginx/conf.d/` - Nginx configuration for Laravel

## Production Notes
- Change `APP_ENV=production` and `APP_DEBUG=false` in `.env` before deploying
- Use strong database password instead of "root"
- Configure MAIL_MAILER with real SMTP service
- Use a dedicated container orchestration tool (Kubernetes) for production scaling
