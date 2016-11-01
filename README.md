#BulletJournal API

This symfony app provides endpoint for the BulletJournal front end, built on angularjs 1.5.*.

It defines the following endpoints:

 * GET /tasks : retrieve all tasks
 * GET /tasks/{id} : retrieve a task by its ID
 * POST /tasks : create a new task
 * PUT /tasks/{id} : update an existing task
 * DELETE /tasks/{id} : delete an existing task

Tasks are defined the following way :
 * task_id
 * title
 * summary
 * done
 * due_date
 * created_at
 * updated_at (unused)

Those endpoints allows the basic CRUD operations on a Task entity.

# Installation and setup

1. Clone the project and fill the config/parameters.yaml
2. run migrations helper (after update the DTB settings and migration schema)
`app/console doctrine:migrations:create`
3. launch the PHP built-in server wrapped by symfony :
`app/console server:run`
