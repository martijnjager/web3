<?php

// Dashboard
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('auth.index'));
});

// Dashboard > users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Users overview', route('auth.user.index'));
});

// Dashboard > users > create
Breadcrumbs::for('user-create', function ($trail) {
    $trail->parent('users');
    $trail->push('Add user', route('auth.user.create'));
});

// Dashboard > users > edit
Breadcrumbs::for('user-edit', function ($trail, $user) {
    if(auth()->user()->role->id > 1)
        $trail->parent('dashboard');
    else
        $trail->parent('users');

    $trail->push('Update user', route('auth.user.edit', $user));
});


// Dashboard > calendar
Breadcrumbs::for('calendar', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Calendar', route('auth.calendar'));
});


// Dashboard > projects
Breadcrumbs::for('projects', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Projects', route('auth.project.index'));
});

// Dashboard > project > view
Breadcrumbs::for('project-show', function ($trail, $project) {
    $trail->parent('projects');
    $p = $project;
    if( ! ($project instanceof \App\Project)) {
        $p = \App\Project::find($project);
    }
    $trail->push($p->name, route('auth.project.show', $project));
});

// Dashboard > project > create
Breadcrumbs::for('project-create', function ($trail) {
    $trail->parent('projects');
    $trail->push('Create Project', route('auth.project.create'));
});

// Dashboard > project > edit
Breadcrumbs::for('project-edit', function ($trail, $project) {
    $trail->parent('projects');
    $trail->push('Edit Project', route('auth.project.create', $project));
});

// Dashboard > project > document > create
Breadcrumbs::for('document-create', function ($trail, $project) {

    if (session('previous') == route('auth.document.index'))
        $trail->parent('documents');
    else
        $trail->parent('project-show', $project);

    $trail->push('Create document', route('auth.project.document.create', $project));
});


// Dashboard > project > task > create
Breadcrumbs::for('task-create', function ($trail, $project) {
    $trail->parent('project-show', $project);
    $trail->push('Add task', route('auth.project.task.create', $project));
});

// Dashboard > project > task > update
Breadcrumbs::for('task-edit', function ($trail, $project, $task) {
    $trail->parent('project-show', $project);
    $trail->push('Update task', route('auth.project.task.update', [$project, $task]));
});

// Dashboard > documents > index
Breadcrumbs::for('documents', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Documents overview', route('auth.document.index'));
});

// Dashboard > projects > bugs > index
Breadcrumbs::for('bugs', function ($trail, $project) {
    $trail->parent('project-show', $project);
    $trail->push('Bug overview', route('auth.project.bug.index', $project));
});

// Dashboard > projects > bugs > create
Breadcrumbs::for('bug-create', function ($trail, $project) {
    $trail->parent('project-show', $project);
    $trail->push('Add bug', route('auth.project.bug.addImage', $project));
});

// Dashboard > projects > bugs > update
Breadcrumbs::for('bug-edit', function ($trail, $project, $bug) {
    $trail->parent('bugs', $project);
    $trail->push('Edit bug', route('auth.project.bug.edit', [$project, $bug]));
});
