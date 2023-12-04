# News Aggregator Backend

This is the backend component of a news aggregator website built using PHP Laravel. It fetches articles from various sources and stores them in a local database. The backend exposes API endpoints for the frontend application to interact with, allowing users to retrieve articles based on search queries, filtering criteria, and user preferences.

## Table of Contents

- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Configuration](#configuration)
  - [Environment Variables](#environment-variables)
- [Usage](#usage)
  - [Fetching Articles](#fetching-articles)
  - [API Endpoints](#api-endpoints)
- [Project Structure](#project-structure)
- [Best Practices](#best-practices)
- [Contributing](#contributing)
- [License](#license)

## Getting Started

### Prerequisites

- PHP 7.4+
- Composer
- Laravel 8

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/hammadpitafi32/news-aggregator.git


##API Endpoints
- /articles
- /articles/{id}

## Fetching Articles

php artisan fetch:news-articles

## Environment Variables

- NEWSAPI_KEY
- NYTAPI_KEY
- GUARDIANAPI_KEY

(Note : Run migration command)