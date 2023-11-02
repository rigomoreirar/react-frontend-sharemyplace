<!DOCTYPE html>
<html>
<head>
    <title>Upload Dashboard</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="/logout" class="button">Logout</a>
</div>

<h2>Upload CSV</h2>

<form action="/dashboard_upload" method="post" enctype="multipart/form-data">
    Select CSV file:
    <input type="file" name="csv" accept=".csv">
    <input type="submit" value="Upload CSV" name="submit">
</form>

</body>
</html>
