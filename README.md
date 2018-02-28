# Daily Slot and Spot - master the scrum daily the best it way.

Best It internal tool for splitting up the 'global' daily into project based dailies.

## How to start

* To start the project

```bash
# Run this once to initialize project
# Must run with "bash" until initialized
bash vessel init  

./vessel start
```

* Run composer 

```bash
./vessel composer install
```

* Edit .env to include your environment variables.  

* To create the db
```bash
# Running Migrations
./vessel artisan migrate
```

before you run the seeding command, you can change the name, email and password for the admin user in [DatabaseSeeder.php](database/seeds/DatabaseSeeder.php)Class.  

Run following to seed your database with admin user and other needed data.

```bash
# Running Seeders
./vessel artisan db:seed

```
The standard username and password are:  
email: admin@admin.com  
password: admin

Head to `http://localhost` in your browser and see your Laravel site!

## Hipchat notifications
In order to send Hipchat notifications to the project members before the daily starting, setup your server and add a Cron job that is calling the Laravel artisan command:

```bash
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
