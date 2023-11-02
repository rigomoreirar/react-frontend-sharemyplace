<!DOCTYPE html>
<html>
<head>
    <title>Edit Dashboard</title>
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

        #userTable, #pacRecordTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            text-align: center;
            border-radius: 10px;
            overflow: hidden;
        }

        #userTable th, #userTable td, #pacRecordTable th, #pacRecordTable td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #userTable th, #pacRecordTable th {
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
        <form action="/dashboard_edit" method="post">
            <input type="hidden" name="type" value="NotLogin">
            <button type="submit" class="back-btn">Back</button>
        </form>
        <h2>Edit table</h2>
    </div>

        <!-- PACRecord Table -->
        <table id="pacRecordTable">
            <thead>
                <tr>
                    <!-- Add table headers based on PACRecord fields -->
                    <th>Action</th>
                    <th>Name</th>
                    <th>Address1</th>
                    <th>Address2</th>
                    <th>PhoneNumber</th>
                    <th>AccountNumber</th>
                    <th>RoutingNumber</th>
                    <th>Amount</th>
                    <th>CheckNumber</th>
                    <th>Memo1</th>
                    <th>Memo2</th>
                    <th>Memo3</th>
                    <th>Memo4</th>
                    <th>Company name</th>
                    <th>Bank Name</th>
                    <th>Category</th>
                    <th>Response</th>
                    <th>File Number</th>
                    <th>Outcome</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacRecords as $record): ?>
                <tr>

                <td>
                        <button class="editBtn">Edit</button>
                        <button class="saveBtn hidden">Save</button>
                        <button class="cancelBtn hidden">Cancel</button>
                    </td>
                    <td>
                        <span class="editable" data-name="Name"><?= $record['Name'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Name" class="inputField hidden" type="text" value="<?= $record['Name'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="Address1"><?= $record['Address1'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Address1" class="inputField hidden" type="text" value="<?= $record['Address1'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="Address2"><?= $record['Address2'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Address2" class="inputField hidden" type="text" value="<?= $record['Address2'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="PhoneNumber"><?= $record['PhoneNumber'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="PhoneNumber" class="inputField hidden" type="text" value="<?= $record['PhoneNumber'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="AccountNumber"><?= $record['AccountNumber'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="AccountNumber" class="inputField hidden" type="text" value="<?= $record['AccountNumber'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="RoutingNumber"><?= $record['RoutingNumber'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="RoutingNumber" class="inputField hidden" type="text" value="<?= $record['RoutingNumber'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="Amount"><?= $record['Amount'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Amount" class="inputField hidden" type="text" value="<?= $record['Amount'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="CheckNumber"><?= $record['CheckNumber'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="CheckNumber" class="inputField hidden" type="text" value="<?= $record['CheckNumber'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="Memo1"><?= $record['Memo1'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Memo1" class="inputField hidden" type="text" value="<?= $record['Memo1'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="Memo2"><?= $record['Memo2'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Memo2" class="inputField hidden" type="text" value="<?= $record['Memo2'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="Memo3"><?= $record['Memo3'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Memo3" class="inputField hidden" type="text" value="<?= $record['Memo3'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="Memo4"><?= $record['Memo4'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Memo4" class="inputField hidden" type="text" value="<?= $record['Memo4'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="CompanyName"><?= $record['CompanyName'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="CompanyName" class="inputField hidden" type="text" value="<?= $record['CompanyName'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="BankName"><?= $record['BankName'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <select name="BankName" class="inputField hidden">
                            <?php foreach ($bankNames as $bankName): ?>
                                <option data-id="<?= $bankName['id'] ?>" value="<?= $bankName['id'] ?>" <?= ($record['idBank'] == $bankName['id']) ? 'selected' : '' ?>><?= $bankName['Name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                    <td>
                        <span data-name="BankCategoryName"><?= $record['BankCategoryName'] ?></span>
                    </td>

                    <td>
                        <span class="editable" data-name="ResponseName"><?= $record['ResponseName'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <select name="ResponseName" class="inputField hidden">
                            <?php foreach ($responseNames as $responseName): ?>
                                <option data-id="<?= $responseName['id'] ?>" value="<?= $responseName['id'] ?>" <?= ($record['idResponse'] == $responseName['id']) ? 'selected' : '' ?>><?= $responseName['Name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                    <td>
                        <span class="editable" data-name="FileNumber"><?= $record['FileNumber'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="FileNumber" class="inputField hidden" type="text" value="<?= $record['FileNumber'] ?>">
                    </td>
                    <td>
                        <span class="editable" data-name="Outcome"><?= $record['Outcome'] ?></span>
                        <input name="id" class="inputField hidden" type="hidden" value="<?= $record['id'] ?>">
                        <input name="Outcome" class="inputField hidden" type="text" value="<?= $record['Outcome'] ?>">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


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

document.getElementById('pacRecordTable').addEventListener('click', function(event) {
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

        fetch('/updatePACHistoryRecords', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ type: 'pacRecordTable', data })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                toggleEditMode(row, false);
                Object.entries(data).forEach(([key, value]) => {
                    const editable = row.querySelector(`.editable[data-name="${key}"]`);
                    
                    if (key === "BankName") {
                        const optionElement = row.querySelector(`select[name="BankName"] option[data-id="${value}"]`);
                        if (optionElement) {
                            value = optionElement.textContent;
                            
                            
                            fetch(`/getBankCategoryName/${value}`)
                            .then(response => response.json())
                            .then(data => {
                                const categorySpan = row.querySelector(`span[data-name="BankCategoryName"]`);
                                if (categorySpan && data.name) {
                                    categorySpan.textContent = data.name;
                                }
                            })
                            .catch(() => {
                                alert('Error fetching the bank category name.');
                            });
                        }
                    } else if (key === "ResponseName") {
                        const optionElement = row.querySelector(`select[name="ResponseName"] option[data-id="${value}"]`);
                        if (optionElement) {
                            value = optionElement.textContent;
                        }
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