<?php
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Table</title>
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
            width: 80%;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
            font-size: 35px;
            font-weight: bold;
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
            align-self: flex-start;
        }

        button.back-btn:hover {            
            background-color: rgb(230, 65, 65);
        }

        #userTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            text-align: center;
            border-radius: 10px;
            overflow: hidden;
        }

        #userTable th, #userTable td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #userTable th {
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

<div class="main-container">

    <form action="/dashboard_root" method="post"> 
        <button type="submit" class="back-btn">Back</button>
        <input type="hidden"  name="back" value="1">
    </form>

    <h2>User Table Root</h2>

    <form action="/dashboard_root/user_table/add_user" method="post"> 
        <button type="submit" class="action-btn">Add new User</button>
    </form>
    <!-- User Table -->
    <table id="userTable">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Password</th>
                <th>Authorization</th>
                <th>Activated</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <span class="editable" data-name="Username"><?= $user['Username'] ?></span>
                    <input name="id" class="inputField hidden" type="hidden" value="<?= $user['id'] ?>">
                    <input name="Username" class="inputField hidden" type="text" value="<?= $user['Username'] ?>">
                </td>
                <td>
                    <span class="editable" data-name="Name"><?= $user['Name'] ?></span>
                    <input name="id" class="inputField hidden" type="hidden" value="<?= $user['id'] ?>">
                    <input name="Name" class="inputField hidden" type="text" value="<?= $user['Name'] ?>">
                </td>
                <td>
                    <span class="editable" data-name="Password"><?= $user['Password'] ?></span>
                    <input name="id" class="inputField hidden" type="hidden" value="<?= $user['id'] ?>">
                    <input name="Password" class="inputField hidden" type="text" value="<?= $user['Password'] ?>">
                </td>


                <td>
                    <span class="editable" data-name="Authorization"><?= $user['Authorization'] ?></span>
                    <input name="id" class="inputField hidden" type="hidden" value="<?= $user['id'] ?>">
                    <select name="Authorization" class="inputField hidden">
                        <?php foreach ($permissions as $permission): ?>
                        <option data-id="<?= $permission['id'] ?>" value="<?= $permission['id'] ?>" <?= ($user['PermissionID'] == $permission['id']) ? 'selected' : '' ?>><?= $permission['Name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>

                <td>
                    <span class="editable" data-name="Activated"><?= ($user['Activated'] == 0) ? 'True' : 'False'?></span>
                    <select name="Activated" class="inputField hidden">
                        <option value="0" <?= ($user['Activated'] == 0) ? 'selected' : '' ?>>True</option>
                        <option value="1" <?= ($user['Activated'] != 0) ? 'selected' : '' ?>>False</option>
                    </select>
                </td>

                <td>
                    <button class="editBtn">Edit</button>
                    <button class="saveBtn hidden">Save</button>
                    <button class="cancelBtn hidden">Cancel</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>

function toggleEditMode(row, editMode) {
    const controls = {
        edit: row.querySelector('.editBtn'),
        save: row.querySelector('.saveBtn'),
        cancel: row.querySelector('.cancelBtn')
    };

    const elements = {
        editables: row.querySelectorAll('.editable'),
        inputs: row.querySelectorAll('.inputField')
    };

    controls.edit.classList.toggle('hidden', editMode);
    controls.save.classList.toggle('hidden', !editMode);
    controls.cancel.classList.toggle('hidden', !editMode);
    elements.editables.forEach(e => e.classList.toggle('hidden', editMode));
    elements.inputs.forEach(e => e.classList.toggle('hidden', !editMode));
}

document.getElementById('userTable').addEventListener('click', function(event) {
    const btn = event.target;
    const row = btn.closest('tr');
    
    if (btn.classList.contains('editBtn')) {
        toggleEditMode(row, true);
    } else if (btn.classList.contains('saveBtn')) {
        const data = Array.from(row.querySelectorAll('.inputField:not([name="id"])')).reduce((acc, input) => {
            acc[input.name] = input.value;
            return acc;
        }, {});
        data.id = row.querySelector('input[name="id"]').value;

        fetch('/updateDataRoot', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ type: 'userTable', data })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                toggleEditMode(row, false);
                Object.entries(data).forEach(([key, value]) => {
                    const editable = row.querySelector(`.editable[data-name="${key}"]`);

                    if (key === "Authorization") {
                        const optionElement = row.querySelector(`select[name="Authorization"] option[data-id="${value}"]`);
                        if (optionElement) {
                            value = optionElement.textContent;
                        }
                    } else if (key === "Activated") {
                        value = value == 0 ? 'True' : 'False';
                    }
                    
                    if (editable) editable.textContent = value;
                });
            } else {
                alert('Error saving data.');
            }
        })
        .catch(() => {
            alert('Error performing the operation.');
        });
    } else if (btn.classList.contains('cancelBtn')) {
        toggleEditMode(row, false);
    }
});


</script>

</body>
</html>