# Project Setup Instructions

Follow these steps to set up the Vonage Video API project on your system:

1. Clone the repository to your local system.
2. Run the following commands:
   - `composer install` or `composer update`
3. Run the following commands:
   - `npm install`
   - `npm run dev`
4. Set up the `.env` file based on the example `.env.example`, adding the necessary credentials.
5. Run the command:
   - `php artisan migrate` (to execute migrations)
6. Start the project with the command:
   - `php artisan serve`
7. Open the URL displayed in the last step in your browser.

Once the project is running:
- Register a new user.
- Log in to the site using your credentials.
