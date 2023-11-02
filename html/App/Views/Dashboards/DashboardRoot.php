<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 700px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 50px;
            color: #333;
            font-size: 35px;
            font-weight: bold;
        }

        button.action-btn {
            margin-bottom: 30px;
            width: 550px;
            padding: 18px;
            background-color: #325377;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 22px;
            transition: background-color 0.3s ease;
            font-weight: bold;
            display: block;
        }

        button.action-btn:hover {
            background-color: #4f749b;
        }

        .back-btn {
            padding: 7px 15px;
            font-size: 16px;
            color: white;
            background-color: red;
            border-radius: 5px;
            border: none;
            margin-bottom: 10px;
            margin-left: 450px;
            text-decoration: none;
        }
        .back-btn:hover {            
            background-color: rgb(230, 65, 65);

        }

    </style>
</head>
<body>

<div class="main-container">
    

    <div class="container">
        <a href="/logout" class="back-btn">Logout</a>
    </div>

    <h2>Dashboard Root</h2>

    <form action="dashboard_root/user_table" method="post" class="user-table-form">
        <button type="submit" class="action-btn">User Table</button>
    </form>

    <form action="/dashboard_root/pac_response_table" method="post" class="pac-response-table-form"> 
        <button type="submit" class="action-btn">PAC Response Table</button>
    </form>
    <form action="/dashboard_root/bank_table" method="post" class="pac-response-table-form"> 
        <button type="submit" class="action-btn">Bank Table</button>
    </form>
    <form action="/dashboard_root/search_input" method="post" class="pac-response-table-form"> 
        <button type="submit" class="action-btn">Logs Table</button>
    </form>
</div>

</body>
</html>