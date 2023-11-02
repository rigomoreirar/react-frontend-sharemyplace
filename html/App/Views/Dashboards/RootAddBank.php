<!DOCTYPE html>
<html>
<head>
    <title>User Table</title>
    <style>
    </style>
</head>
<body>

<form action="/dashboard_root/bank_table" method="post"> 
  <div class="container">
    <button type="submit">Back</button>
  </div>
</form>

<h2>Add Bank</h2>

<form action="/dashboard_root/bank_table/add_bank/add_request" method="post"> 
  <div class="container">

    <label for="password"><b>Name</b></label>
    <input type="text" placeholder="Enter Name" name="name" required>

    <label for="password"><b>Description</b></label>
    <input type="text" placeholder="Enter description" name="description" required>
    
    <input type="hidden" name="type" value="bankTable">
    <input type="hidden" name="username" value="pacResponseTable">
    <input type="hidden" name="password" value="pacResponseTable">

    <button type="submit">Add</button>
  </div>
</form>