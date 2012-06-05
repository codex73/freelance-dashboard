freelance-dashboard
===================

Freelance Dashboard was created with the goal of providing a minimal grid to help keep track of project tasks, assignments and progress. 

There are many project management tools available with tons of features, they are good and when used in teams work great also. 
Neverless I found that these available project management tools took much time to setup, manage and sometimes could be confusing. 

I started coding what I believe could be a simple one page dashboard where I could 
easily keep track of my projects. This is all I needed.

As of now, the one page "multido.php" is able to manage multiple grids(boards = projects), different uri user id's, 
add boxes(project lists, assignments, task groups), add tasks(box entries), delete boxes, change statuses of box entries.

Project is built using PHP,MYSQL and Twitter Bootstrap Framework

Not much work has been place yet on this, so it's very much a work in progress. If you'd like to help, please do. 
I'll like to see what we could do together. Simplistic, Minimal and Easy.

The Screenshot
-----------

![Alt text](https://github.com/codex73/freelance-dashboard/raw/master/freelance-dashboard1.png "Screenshot")

Installation
-----------

I've included the db structure in 'db' folder. You could be able to simply publish the folder into your local development enviroment of choice, 
configure the database "multido.php" [yes, it's still messy and all inside one file] and get the ball rolling.

Things that could make this better:

* A User System -> sign up module.
* Boards Management -> add boards(projects), rename boards, delete boards.
* Boards Collaboration -> sharing - permission for other users to boards and/or boxes within.

Usage
-----------

e.g.

http://yourhost/projectfolder/multido.php?uid=1&prj=3

http://yourhost/projectfolder/multido.php?uid=1&prj=board_number_here

You could create multiple users permissions on table named "box_perm". The members table is not currently used or integrated, it could be empty.

How to Contribute
------------

1. Fork it.
2. Create a branch (`git checkout -b my_youruser`)
3. Commit your changes (`git commit -am "Added Some Goodies"`)
4. Push to the branch (`git push origin my_youruser`)
5. Create an [Issue][1] with a link to your branch
6. Thanks so much, I'll review your creation.

Stuff it Needs
------------

* Separation of code [js css php]
* Ability to rename box names.
* Ability to rename board names.
* Update open tasks count on DOM change.
* Populate project links from database.
* Integration of a template system (e.g. smarty or others). Separation of code from view.
* Fix of current media queries for different screen sizes.