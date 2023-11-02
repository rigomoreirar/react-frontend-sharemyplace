<!DOCTYPE html>
<html>
<head>
    <title>User Table</title>
    <style>
    </style>
</head>
<body>

<form action="/dashboard_root/user_table" method="post"> 
  <div class="container">
    <button type="submit">Back</button>
  </div>
</form>

<h2>Add User</h2>

<form action="/dashboard_root/user_table/add_user/add_request" method="post"> 
  <div class="container">
    
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="password"><b>Name</b></label>
    <input type="text" placeholder="Enter Name" name="name" required>

    <label for="password"><b>Password</b></label>
    <input type="text" placeholder="Enter Password" name="password" required>
    
    <input type="hidden" name="type" value="userTable">
    <input type="hidden" name="description" value="userTable">

    <button type="submit">Add</button>
  </div>
</form>