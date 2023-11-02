<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 30px;
            margin-bottom: 50px;
            font-weight: bold;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        label {
            display: block;
            margin-bottom: 30px;
            color: #555;
            font-weight: bold;
            text-align: center;
            font-size: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        button {
            
            margin-top: 20px;
            width: 80%;
            padding: 15px;
            background-color: #325377;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
            font-weight: bold;
            margin-left: auto;
            margin-right: auto;
            display: block; 
        }

        button:hover {
            background-color: #4f749b;
        }

    </style>
</head>
<body>

<form action="/" method="post"> 
  <div class="container">

    <h2>Login Form</h2>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <input type="hidden"  name="type" value="Login">

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <button type="submit">Login</button>
  </div>
</form>

</body>
</html>