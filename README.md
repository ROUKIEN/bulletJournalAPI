#BulletJournal API

[![Build Status](https://travis-ci.org/ROUKIEN/bulletJournalAPI.svg?branch=master)](https://travis-ci.org/ROUKIEN/bulletJournalAPI)

This symfony app provides endpoint for the BulletJournal front end, built on angularjs 1.5.*. It is a simple demo app.

Endpoints are defined in the Rukien/BulletJournalBundle controller directory

Tasks are defined the following way :
 * task_id
 * title
 * summary
 * assignee (the user in charge of the task)
 * done
 * due_date
 * created_at
 * updated_at (unused)

Those endpoints allows the basic CRUD operations on a Task entity.

# Installation and setup

1. Clone the project
2. run `composer install` (you'll need to set your MySQL/MariaDB database credentials)
3. run `app/console doctrine:schema:update --force`
3. run `app/console doctrine:fixtures:load` to fill the app with initial dataset
4. launch the PHP built-in server wrapped by symfony `app/console server:run`

Your API is now up and running. You can use it through the BulletJournalFront app.
