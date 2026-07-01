# TalentHub Docker Setup

Complete Docker configuration for running TalentHub in containerized environment.

## Services

- **app** - PHP 8.4-FPM application container
- **nginx** - Web server (port 80)
- **mysql** - MySQL 8.0 database (port 3306)
- **redis** - Redis cache server (port 6379)
- **queue** - Laravel queue worker

## Quick Start

### 1. Environment Setup

Copy environment file:
```bash
cp .env.example .env
```

Update these variables in `.env`:
```env
DB_HOST=mysql
DB_DATABASE=talenthub
DB_USERNAME=root
DB_PASSWORD=secret

REDIS_HOST=redis
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 2. Build and Start

```bash
docker-compose up -d --build
```

### 3. Install Dependencies

```bash
docker-compose exec app composer install
docker-compose exec app npm install
docker-compose exec app npm run build
```

### 4. Generate Application Key

```bash
docker-compose exec app php artisan key:generate
```

### 5. Run Migrations

```bash
docker-compose exec app php artisan migrate
```

## Common Commands

### Container Management

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# Restart containers
docker-compose restart

# View logs
docker-compose logs -f

# View specific service logs
docker-compose logs -f app
```

### Application Commands

```bash
# Run artisan commands
docker-compose exec app php artisan [command]

# Access container shell
docker-compose exec app sh

# Run tests
docker-compose exec app php artisan test

# Clear cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Database Management

```bash
# Access MySQL
docker-compose exec mysql mysql -u root -p

# Import database
docker-compose exec -T mysql mysql -u root -psecret talenthub < dump.sql

# Export database
docker-compose exec mysql mysqldump -u root -psecret talenthub > dump.sql
```

### Redis Management

```bash
# Access Redis CLI
docker-compose exec redis redis-cli

# Clear Redis cache
docker-compose exec redis redis-cli FLUSHALL
```

## File Structure

```
docker/
├── nginx/
│   └── default.conf      # Nginx configuration
├── entrypoint.sh         # Container startup script
└── README.md             # This file
```

## Development vs Production

### Development (default)
- Uses `docker-compose.override.yml` for local settings
- Port 8080 for web (avoiding port 80 conflicts)
- Debug mode enabled
- Hot reload for code changes

### Production
- Remove `docker-compose.override.yml`
- Use environment-specific `.env`
- Enable opcache and optimize autoloader
- Use proper SSL certificates

## Troubleshooting

### Permission Issues

```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Database Connection Failed

1. Check if MySQL is ready:
```bash
docker-compose exec mysql mysqladmin ping -h localhost
```

2. Verify environment variables:
```bash
docker-compose exec app php artisan config:show database
```

### Port Already in Use

Edit `docker-compose.override.yml` to change ports:
```yaml
nginx:
  ports:
    - "8080:80"  # Change 8080 to another port
```

### Clear All Data and Restart

```bash
docker-compose down -v
docker-compose up -d --build
```

## Performance Optimization

### Enable Opcache (Production)

Add to Dockerfile:
```dockerfile
RUN docker-php-ext-install opcache
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
```

### Adjust PHP Memory Limits

Create `docker/php.ini`:
```ini
memory_limit = 512M
upload_max_filesize = 100M
post_max_size = 100M
```

Mount in docker-compose.yml:
```yaml
app:
  volumes:
    - ./docker/php.ini:/usr/local/etc/php/conf.d/custom.ini
```

## Security Notes

- Change default passwords in production
- Use secrets management for sensitive data
- Enable HTTPS with valid certificates
- Regularly update base images
- Use non-root user for application (www-data)

## Additional Resources

- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Docker Best Practices](https://docs.docker.com/develop/dev-best-practices/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
