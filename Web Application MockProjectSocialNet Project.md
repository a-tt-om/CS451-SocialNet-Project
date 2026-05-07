## Web Application Mock Project

SocialNet Project

This assignment requires you to implement “Social Network” web application project with
the following specifications:

- Create a github repository in your personal GitHub account to store your project
  code.
  o Do not share Github account.
  o Set your repository visibility to “public” when you submit
- Use PHP, MySQL, Nginx and Linux as your “techstack”
- Database: The application uses a database named “socialnet”. The database
  contains a single table “account” with the following columns (you can decide
  column names and column types as long as it is reasonable):
  o Id
  o username
  o fullname
  o password
  o description
- The application should implement the following pages
  o Admin Page:
  ▪ URL: /admin/newuser.php
  ▪ Description: Form to create/add new user to the system
  o SignIn Page:
  ▪ URL: /socialnet/signin.php
  ▪ Description: Login page using a user account created by Admin Page.
  After successfully signing in, user should be redirected to Home Page.
  o Home Page:
  ▪ URL: /socialnet/index.php

## ▪ Description:

- This is Home page of the app. If the user is not logged in, the
  page should redirect the user to Signin Page.
- Its main content should show user information including:
  “username”, and “fullname”.

- It should have a list of other users in the system. The list allows
  the user to see Profile Page of other users. See Profile Page for
  more details.
- It should also have a MenuBar for navigating to other pages.
  See MenuBar for details.
  o Setting Page:
  ▪ URL: /socialnet/setting.php

## ▪ Description:

- It contains a form that allows the user to edit “Profile Page
  content”. The profile page content can be stored in
  “description” column of “account” table.
- It should have Menubar for navitaging to other pages. See
  MenuBar for details
  o Profile Page:
  ▪ URL: /socialnet/profile.php
  ▪ Query string (optional): ?owner=some_user

## ▪ Description:

- It accepts a query string that contains “owner” to specify the
  owner of the profile page. If no query string exists, the logged in
  user is used as the owner.
- It should indicate the owner of the profile page.
- It shows “Profile Page content” stored in “description” column
  that is set by Setting Page.
- It should have Menubar for navitaging to other pages. See
  MenuBar for details
  o About Page:
  ▪ URL: /socialnet/about.php

## ▪ Description:

- Simple page that contains “student name” and “student
  number” (static content).
- It should have Menubar for navitaging to other pages
  o Signout Page:
  ▪ URL: /socialnet/signout.php

## ▪ Description:

- For signing out.
- This page after resetting the session data should redirect the
  user to Home Page or to Signin Page

o MenuBar:
▪ This is a common part of Home/Profile/Setting/About page.
▪ It contains menu items:

- Home : linked to Home Page
- Setting : linked to Setting Page
- Profile: linked to Profile Page (no querystring)
- About: linked to About Page
- SignOut: linked to SignOut Page
- Your submission is expected to be error-free.
- Your git repo is expected to have “db.sql” that contains SQL statements to create
  your application DB, and to create tables according your implementation. I will use
  it for database creation in a new testing environment.
- You can also prepare a README.md with your necessary notes for setting up the
  application in a new environment.
- You are welcome to extend the application features. The new features should be
  declared in README.md file.
- Submit your github link (use https) via submission form (Google Form)
  ----------------------------------------------- End ------------------------------------------------------
