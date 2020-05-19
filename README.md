**WEB3**

Website developed by Martijn Jager and Kateryna Popova

How to configure the website after composer is finished:
- Run 'php artisan setup:run 1'
- - This command will generate a new laravel key (for sessions and secure encrypted data), run migrations and seed the tables
- Run 'php artisan setup:run'
- - This command will run migrations and seed the tables



Has:
- Project management
- User management
- Calendar
- Document management

Projects:
- Only administrators can see all projects and can create new projects
- Developers and clients can only see projects they're assigned to
- Only developers and administrators can perform actions on projects and tasks
- A few REST patches are made when only a field needs to be updated
- Projects and tasks have a live timer which runs when a task is running
- Whenever a task is edited, its details are displayed in a modal
- The assigned user to a task can be edited in the project overview

Users:
- Developers and clients can only edit their own profiles
- Administrators can see and edit all profiles

Calendar:
- Calendar events are tasks from projects
- Only tasks of projects a user participates in are shown

Documents:
- PDF files can be easily created with the tinyMCE editor with file manager
- PDF files are connected to projects
- Only those participating in a project can see PDFs connected to the project

Others:
- Routes are extensively grouped from the beginning
- There are a few repositories to separate logic from the controllers or models
- A custom blade directive (@role('role')) exists
- Certain logic are not in classes, but in traits to make them easily reusable, traits are necessary due to the limit from PHP of extending from 1 class only (diamond problem)
- Tasks, users and Projects have validation logic in request classes
- Sb-admin template is used in the dashboard
- Breadcrumbs are used to easily get 2 or more pages back


| Week | Martijn Jager | Kateryna Popova | Together |
| ------ | ------ | ------ | ------ |
| 1 | Created an app <br> Added sb-admin template for dashboard <br> Added breadcrumbs <br> Started with CRUD for users <br> Started projects branch | <br>Installed Laravel<br> Created an app<br> Merged with projects branch|  |
| 2 | Added migrations <br> Added seeders <br> Improved CRUD for users <br> Updated Laravel from 5.6 to 5.8 <br> Added migrations and relations <br> Added request validation for user <br> Added custom blade directive <br> Added authorization in the menu <br> Updated breadcrumbs |Added migrations<br> Added seeds to migrations| App creation <br> idea brainstorming <br>Authorization|
| 3 | Added helpers for time related tasks <br> Added R (CRUD) views for projects and tasks <br> Added relations for projects and tasks <br> Added project repository <br> Added seeders <br> Added breadcrumbs <br> Added custom command for easy initialization of the database and key <br> Added live timer for tasks <br> Updated migrations | Changed the order for migrations and seeds(was a bug while migrate:refresh)<br> Added new migrations<br> Added seeds to new migrations <br> More models and relations <br> Added routes<br>Added breadcrumbs <br> Calendar backend<br>Calendar overview<br>Adopted CRUD functionality for tasks&calendar | Fixed issue with foreign keys in migrations caused by the use of an improper data type <br> Integers were used for the attributes which are interpreted as signed integers which can contain negative values, to resolve this unsignedInteger is used for foreign keys |
| 4 | Added option to upload image with small preview for users and resize image on upload <br> Added default option for ignoring the key:generation command in the custom command so only migrate:fresh and db:seed are by default run <br> Removed unused controllers <br> Made start with user export to excel file <br> Updated calendar view to match design with other views <br> Added validation for new projects 
| 5 | Added option to mark a task as finished <br> Updated TaskController to ensure any running timers on a task that's marked as finished is stopped <br> | | |
| 6 | Added logic for editing a project <br> Updated project validation <br> Updated factories and seeders <br> Added patch to assign a user to a task <br> Added project policy <br> Added tinyMCE editor with file manager <br> Updated breadcrumbs to prevent issues <br> Added option to create PDF files <br> | | |
| 7 | Fixed a directory not present bug when creating files <br> Added authorization to projects, tasks and users <br> Added time counting to project if a task is running <br> Attempted using REST API for users <br> Added color legend for tasks and projects <br> Finetuned permissions | Changed routing for bugs in projects <br> Changed migrations and models (for debugging) <br> Changed Controllers for inserting bugs into the projects <br> Images in the bugs table |Debugging database issues, routing issues, etc.  |
