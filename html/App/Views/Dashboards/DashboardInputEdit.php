<!DOCTYPE html>
<html >
<head>
    <title>Date Selection</title>
</head>
<body>
<div class="container">
    <a href="/logout" class="button">Logout</a>
</div>

<h2>This is the date submit view</h2>

<form action="/dashboard_edit/table" method="get">
    <label for="firstDate">First Date:</label>
    <input type="date" id="firstDate" name="firstDate" required>

    <label for="secondDate">Second Date:</label>
    <input type="date" id="secondDate" name="secondDate" required>

    <button type="submit">Submit Dates</button>
</form>
</body>
</html>
