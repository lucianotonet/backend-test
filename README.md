# Thunderbite Laravel Test

This project is designed to test laravel and algorithm knowledge
and it is good representation of core skills required to become
a Thunderbite member 
## Installation

1. Clone this repository
1. Run composer install
1. Create and fill the .env file (example included /.env-example)
1. Run `php artisan migrate` to create database tables
1. Seed the database by running `php artisan db:seed`
1. Seed the database with faker data `php artisan db:seed --class='GamesTableSeeder'`
1. Run `npm install`
1. Run `npm run dev`
1. Visit http://thunderbite-test.test/backstage and happy coding

Login details: test@thunderbite.com / test123

## Task Details:

##### Part 1
Slot games are perhaps the most common type of casino game that exist. 5 reel slots is a popular slot machine game available in casino's 
and online platforms. Reels are the vertical sections set into motion when the spin button is pushed, A game can have three, 
five or seven reels and these are multiplied by three or more columns to create a grid of symbols which must organize into 
predetermined paylines for a win. 

Create an algorithm that generates a 5 x 3 array that simulates 5 reel slots e.g
```
[
    [4, 3, 1, 4, 6]
    [2, 5, 3, 2, 1]
    [5, 2, 3, 6, 1]
]  
```
A winning line is created when an array has 3 to 5 same prize IDs in succession in the 
predefined payline. 
 ```
 [
    [1,  2,  3,  4,  5 ]
    [6,  7,  8,  9,  10]
    [11, 12, 13, 14, 15]
]
```

All the possible paylines for the given example are: 1-2-3-4-5, 6-7-8-9-10,
11-12-13-14-15, 1-7-13-9-5, 11-7-3-9-15, 6-2-3-4-10, 6-12-13-14-10, 1-2-8-14-15,
11-12-8-4-5.

Each symbol should have a configurable points and weight (in the backoffice) for 3, 4 and 5 matches.
User should be allowed to create new symbols and upload 1 image which would represent it.
As a part of game launch validation, minimum of 6 and maximum of 10 symbols should be present/active in the
backoffice. Please provide a database seeder for a default configuration.
If there are 6 symbols 
At the end of the game the total sum of points should be shown.

When user opens a campaign url, game should be created, taking into account
 all necessary checks (start, end dates and required params e.g 'a=account').
User will have a certain amount of spins per day. For simplicity make this 
configurable as an url parameter.

Frontend should contain 1 button ('Spin') which will
 simulate clicking the spin button on the slot machine and will trigger ajax call that returns 
 the 5x3 array. Awarded points and symbols should be saved in games table and displayed in 
 Games section in the backoffice. Don't create more than 1 game per day per user.

 ##### Part 2
 All user games can be accessed from backstage/games section.
 This page contains filters that are functional,
  but query needs to be optimized.
 Database might also contain mistakes and needs optimization
 and extra fields in certain tables.
 
 Loading of games section can be greatly improved with
 appropriate optimizations.
 
 All changes to database should be done with new migrations.
 


## Documentation

- [Laravel](https://laravel.com/docs/8.x)
