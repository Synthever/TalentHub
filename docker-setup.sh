#!/bin/bash

# TalentHub Docker Setup Script
# This script helps you set up the TalentHub application using Docker

set -e

echo "========================================="
echo "   TalentHub Docker Setup"
echo "========================================="
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "❌ Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

echo "✅ Docker and Docker Compose are installed"
echo ""

# Check if .env file exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env
    echo "✅ .env file created"
else
    echo "✅ .env file already exists"
fi

echo ""
echo "🔨 Building Docker containers..."
docker-compose build

echo ""
echo "🚀 Starting Docker containers..."
docker-compose up -d

echo ""
echo "⏳ Waiting for services to be ready..."
sleep 10

echo ""
echo "📦 Installing PHP dependencies..."
docker-compose exec app composer install --no-interaction

echo ""
echo "📦 Installing Node dependencies..."
docker-compose exec app npm install

echo ""
echo "🎨 Building frontend assets..."
docker-compose exec app npm run build

echo ""
echo "🔑 Generating application key..."
docker-compose exec app php artisan key:generate --no-interaction

echo ""
echo "🗄️  Running database migrations..."
docker-compose exec app php artisan migrate --force --no-interaction

echo ""
echo "========================================="
echo "   ✅ Setup Complete!"
echo "========================================="
echo ""
echo "🌐 Application URL: http://localhost:8080"
echo ""
echo "Useful commands:"
echo "  - View logs:      docker-compose logs -f"
echo "  - Stop services:  docker-compose down"
echo "  - Restart:        docker-compose restart"
echo "  - Run tests:      docker-compose exec app php artisan test"
echo ""
echo "Or use Makefile commands:"
echo "  - make help       Show all available commands"
echo "  - make logs       View container logs"
echo "  - make shell      Access app container"
echo ""
