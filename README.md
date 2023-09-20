# Sportify - Laravel Application

## Description
Sportify is a Laravel application that allows users to request paid custom training programs from their chosen coach. It includes additional features such as a Calorie Calculator and Water Tracker.

## Features
### For the Player
- Register/Login
- View/Edit personal profile
- Calculate daily calories
- Count cups of water
- View a list of coaches ordered by rate
- Search coaches by name
- View coach's profile
- Make a complaint for coach
- Request a program from chosen coach

### For the Coach
- Register/Login
- View/Edit personal profile
- Calculate daily calories
- Count cups of water
- Reverse status
- View personal training request
- View personal training request history
- Respond to a request (accept or reject)

### For the Admin
- View accounts (player, coach)
- Freeze an account
- Respond to coaches joining requests to the app
- View joining requests
- View received complaints

## Technologies Used
- Laravel/Sanctum for API token authentication
- Nutritionix API for nutrition data
- Mifflin-St. Jeor equation for calorie calculation
- Gmail SMTP for email verification with code for player and coach
- Laravel Task Scheduling for updating the daily counter of the water and calorie every day at 12am
- Role-Based Access Control (RBAC)
- Firebase Cloud Messaging (FCM) for push notifications

## Calculations
- Calorie Calculator: Uses the Mifflin-St. Jeor equation for calculating Basal Metabolic Rate (BMR) and then multiplies it by an activity level factor to get the daily calorie intake.
- Water Tracker for Player: Calculates daily water intake based on body weight and activity level.
- Water Tracker for Coach: Suggests drinking 0.5 to 1 ounce of water per pound of body weight.

## Testing
Unit tests have been written to ensure the functionality of the application.

## Database
The application uses Laravel's Eloquent ORM for database operations.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)
