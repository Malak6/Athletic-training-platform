# Sportify - Laravel Application

## Description
Sportify is a Laravel application that allows users to request paid custom training programs from their selected coach. It includes additional features such as a Calorie Calculator and Water Tracker.

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
- View joining requests
- Respond to coaches joining requests to the app
- View received complaints

## Technologies Used
- Laravel/Sanctum for API token authentication
- Nutritionix API for nutrition data to calculate the calories from food
- Mifflin-St. Jeor equation for calorie calculation
- Gmail SMTP for email verification with code for player and coach
- Laravel Task Scheduling for updating the daily counter of the water and calorie every day at 12am
- Role-Based Access Control (RBAC) (implemented independently)
- Firebase Cloud Messaging (FCM) for push notifications
- Laravel Eloquent ORM with MySQL

## Calculations
- Calorie Calculator: Uses the Mifflin-St. Jeor equation for calculating Basal Metabolic Rate (BMR) and then multiplies it by an activity level factor to get the daily calorie intake.
      which :
      BMR = (10 x weight in kg) + (6.25 x height in cm) - (5 x age in years) – 161
      Daily Calorie Intake = BMR x Activity level factor

- Water Tracker for Player: Calculates daily water intake based on body weight and activity level. 
      Daily water intake = (body weight in pounds / 2.2) x (activity level factor)

- Water Tracker for Coach: Suggests drinking 0.5 to 1 ounce of water per pound of body weight.

## Testing
Unit tests have been written to ensure the functionality of the application (White box testing).

## Database
The application uses Laravel's Eloquent ORM for database operations (MYSQL).

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
