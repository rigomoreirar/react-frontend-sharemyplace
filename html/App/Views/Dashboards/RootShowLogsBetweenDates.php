<!DOCTYPE html>
<html>
<head>
    <title>Log Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
            font-size: 35px;
            font-weight: bold;
            margin-left: 30rem;
        }

        button.action-btn {
            margin-bottom: 30px;
            width: 200px;
            padding: 11px;
            background-color: #325377;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            font-weight: bold;
            align-self: flex-end;
        }

        button.action-btn:hover {
            background-color: #4f749b;
        }

        button.back-btn {
            padding: 7px 15px;
            font-size: 16px;
            color: white;
            background-color: red;
            border-radius: 5px;
            border: none;
            margin-bottom: 10px;
            margin-right: 10rem;
        }

        button.back-btn:hover {
            background-color: rgb(230, 65, 65);
        }

        #logBetweenDatesTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            text-align: center;
            border-radius: 10px;
            overflow: hidden;
        }

        #logBetweenDatesTable th, #logBetweenDatesTable td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #logBetweenDatesTable th {
            background-color: #f2f2f2;
            color: #333;
        }

        .editBtn, .saveBtn {
            padding: 7px 15px;
            font-size: 16px;
            color: white;
            background-color: green;
            border-radius: 5px;
            border: none;
            margin-right: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .editBtn:hover, .saveBtn:hover {
            background-color: #128622;
        }

        .cancelBtn {
            padding: 7px 15px;
            font-size: 16px;
            color: white;
            background-color: red;
            border-radius: 5px;
            border: none;
            margin-left: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cancelBtn:hover {
            background-color: rgb(230, 65, 65);
        }

        .hidden {
            display: none;
        }

    </style>
</head>

<body>

    <div class="container">
        <form action="/dashboard_root/search_input" method="post">
            <input type="hidden" name="type" value="NotLogin">
            <button type="submit" class="back-btn">Back</button>
        </form>
        <h2>Log Dashboard</h2>
    </div>

        <table id="logBetweenDatesTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Modified Values</th>
                    <th>New Values</th>
                    <th>Latest Values</th>                    
                </tr>
            </thead>
            
        <tbody>
            <?php foreach ($Logs as $Log): ?>
            <tr>
                <td>
                    <span class="editable" data-name="Date"><?= $Log['Date'] ?></span>
                </td>
                <td>
                    <span class="editable" data-name="User"><?= $Log['User'] ?></span>
                </td>
                <td>
                    <span class="editable" data-name="Modified"><?= $Log['Modified'] ?></span>
                </td>
                <td>
                    <span class="editable" data-name="New"><?= $Log['New'] ?></span>
                </td>
                <td>
                    <span class="editable" data-name="Latest"><?= $Log['Latest'] ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>