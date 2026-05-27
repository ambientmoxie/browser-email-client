# Browser Email Client (BonoBro)

<img src="docs/images/cover.png" width="500" />

A simple browser interface built on top of [PHPMailer](https://github.com/PHPMailer/PHPMailer) to send HTML emails from a PHP server. This tool kind of reinvents the wheel as it's just an email client in the browser. It was built for a client who needed a simple way to send HTML emails to a moderate number of recipients. It was also a good excuse to build something with HTMX.

Beware, Mailchimp.

## Setup

### Prerequisites

- PHP 8.0+, Composer, Node.js 20+ / or just **Docker**

### 1. Configure your environment

Copy the example file and fill in your SMTP credentials:

```bash
cp .env-example .env
```

```env
SMTP_HOST=smtp.example.com
SMTP_USERNAME=your@email.com
SMTP_PASSWORD=yourpassword
SMTP_PORT=587
FROM_EMAIL=your@email.com
FROM_NAME=Your Name
```

### 2a. Run locally

```bash
npm install && composer install
npm run dev
```

Opens at [http://localhost:8888](http://localhost:8888). Both the PHP and Vite dev servers start concurrently, with HMR on JS, SCSS, and PHP files.

### 2b. Run with Docker

```bash
docker compose up
```

Same result, no local dependencies required.
