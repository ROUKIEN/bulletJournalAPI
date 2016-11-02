#BulletJournal API

This symfony app provides endpoint for the BulletJournal front end, built on angularjs 1.5.*.

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

1. Clone the project and fill the config/parameters.yaml
2. run migrations helper (after update the DTB settings and migration schema):
`app/console doctrine:migrations:create`
3. launch the PHP built-in server wrapped by symfony :
`app/console server:run`
