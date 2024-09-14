# Daily Hope

## Overview

This is the backend API service for a news portal application. It provides endpoints for user authentication, article management, comments, notifications, and admin dashboard functionalities.

## Table of Contents

- [Authentication Routes](#authentication-routes)
- [Public Routes](#public-routes)
- [Authenticated Routes](#authenticated-routes)
  - [User Profile](#user-profile)
  - [Article Management](#article-management-editors)
  - [Article Reactions & Tags](#article-reactions--tags)
  - [Notifications](#notifications)
  - [Admin Routes](#admin-routes)
- [Running the API](#running-the-api)

## Authentication Routes

### `POST /auth/register`
Register a new user.

### `POST /auth/login`
Authenticate a user and return a token.

### `POST /auth/logout`
Log out the user by invalidating the token (requires authentication).

## Public Routes

### `GET /articles`
Retrieve a list of articles.

### `GET /articles/{id}`
Retrieve a specific article by ID.

### `POST /articles/{id}/comments`
Post a comment on an article (requires authentication).

### `DELETE /articles/{id}/comments`
Delete a comment by ID (requires authentication).

## Authenticated Routes

### User Profile

#### `GET /user`
Retrieve the authenticated user’s profile.

### Article Management (Editors)

#### `POST /articles`
Create a new article (requires editor role).

#### `PUT /articles/{id}`
Update an existing article (requires editor role).

#### `DELETE /articles/{id}`
Delete an article (requires editor role).

### Article Reactions & Tags

#### `POST /articles/{id}/react`
React to an article (requires authentication).

#### `POST /articles/{id}/tags`
Add tags to an article (requires authentication).

#### `GET /articles/trending`
Retrieve trending articles based on reactions (requires authentication).

### Notifications

#### `GET /notifications`
Retrieve notifications for the authenticated user.

#### `PUT /notifications/{id}/read`
Mark a notification as read (requires authentication).

## Admin Routes

### User Management

#### `GET /users`
Retrieve a list of all users (requires admin role).

#### `GET /users/top-fans`
Retrieve users who have reacted the most (requires admin role).

#### `GET /users/top-editors`
Retrieve editors who have written the most articles (requires admin role).

### Admin Dashboard

#### `GET /dashboard`
Retrieve general dashboard statistics (requires admin role).

#### `GET /dashboard/recent-articles`
Retrieve recent articles for the dashboard (requires admin role).

#### `GET /dashboard/users`
Retrieve a list of users for the dashboard (requires admin role).

#### `GET /dashboard/analytics`
Retrieve analytics data for the dashboard (requires admin role).

### Article Approval and Archiving

#### `PUT /articles/{id}/approve`
Approve an article (requires admin role).

#### `PUT /articles/{id}/archive`
Archive an article (requires admin role).

## Running the API

1. Clone the repository:
   ```bash
   git clone <repository-url>
