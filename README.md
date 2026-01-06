 # Taak Blogify

A robust Laravel-based blogging platform with social features including posts, comments, likes, and private messaging.

## Features

- **Authentication**: Secure login and registration system.
- **Posts**: Users can read rich-text posts with images.
- **Comments**:
    - Comment on posts.
    - Delete your own comments.
    - **Save Comments**: Bookmark comments for later reference.
- **Likes**: Like and unlike posts.
- **Private Messages**: Send private messages to other users.
- **Admin Panel**: Manage posts, users, and FAQ sections.
- **FAQ System**: Frequently asked questions managed by admins.

## Installation

1.  **Clone the repository**
    ```bash
    git clone <repository-url>
    cd taak-blogify
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    - Copy `.env.example` to `.env`
    - Configure your database credentials in `.env`

4.  **Generate Key and Migrate**
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

5.  **Build Assets**
    ```bash
    npm run dev
    # or for production
    npm run build
    ```

## Usage

-   **Home Page**: View latest posts.
-   **Register/Login**: Access interactive features like commenting and liking.
-   **Dashboard**: Manage your profile.
-   **Save a Comment**: Navigate to a post, find a comment, and click "Save".

## Technologies

-   **Framework**: Laravel 11.x
-   **Frontend**: Blade Templates + Tailwind CSS
-   **Database**: MySQL / SQLite
