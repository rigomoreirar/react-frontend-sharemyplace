<!DOCTYPE html>
<html >
<head>
    <title>Search Logs</title>
</head>
<body>
<form action="/dashboard_root" method="post"> 
    <button type="submit" class="back-btn">Back</button>
    <input type="hidden"  name="back" value="1">
</form>

<h2>Submit date</h2>

<form action="/dashboard_root/search_input/search_by_date" method="get">
    <label for="firstDate">First Date:</label>
    <input type="date" id="firstDate" name="firstDate" required>

    <label for="secondDate">Second Date:</label>
    <input type="date" id="secondDate" name="secondDate" required>

    <button type="submit">Submit Dates</button>
</form>

</body>
</html>