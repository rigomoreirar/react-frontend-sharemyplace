<?php
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Table</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<form action="/dashboard_root" method="post"> 
  <div class="container">
    <input type="hidden"  name="back" value="1">
    <button type="submit">Back</button>
  </div>
</form>

<h2>Bank Table Root</h2>

<form action="/dashboard_root/bank_table/add_bank" method="post"> 
  <div class="container">
    <button type="submit">Add new Bank</button>
  </div>
</form>
<!-- User Table -->
<table id="bankTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Bank Status</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($Banks as $Bank): ?>
        <tr>
            <td>
                <span class="editable" data-name="Name"><?= $Bank['Name'] ?></span>
                <input name="id" class="inputField hidden" type="hidden" value="<?= $Bank['id'] ?>">
                <input name="Name" class="inputField hidden" type="text" value="<?= $Bank['Name'] ?>">
            </td>
            <td>
                <span class="editable" data-name="Description"><?= $Bank['Description'] ?></span>
                <input name="id" class="inputField hidden" type="hidden" value="<?= $Bank['id'] ?>">
                <input name="Description" class="inputField hidden" type="text" value="<?= $Bank['Description'] ?>">
            </td>

            <td>
                <span class="editable" data-name="BankStatus"><?= $Bank['BankStatus'] ? 'True' : 'False' ?></span>
                <select name="BankStatus" class="inputField hidden">
                    <option value="True" <?= $Bank['BankStatus'] ? 'selected' : '' ?>>True</option>
                    <option value="False" <?= !$Bank['BankStatus'] ? 'selected' : '' ?>>False</option>
                </select>
            </td>

            <td>
                <span class="editable" data-name="Category"><?= $Bank['Category'] ?></span>
                <input name="id" class="inputField hidden" type="hidden" value="<?= $Bank['id'] ?>">
                <select name="Category" class="inputField hidden">
                    <?php foreach ($Categories as $Category): ?>
                        <option data-id="<?= $Category['id'] ?>" value="<?= $Category['id'] ?>" <?= ($Bank['idBankCategory'] == $Category['id']) ? 'selected' : '' ?>><?= $Category['Name'] ?></option>
                    <?php endforeach; ?>
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

document.getElementById('bankTable').addEventListener('click', function(event) {
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
            body: JSON.stringify({ type: 'bankTable', data })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                toggleEditMode(row, false);
                Object.entries(data).forEach(([key, value]) => {
                    const editable = row.querySelector(`.editable[data-name="${key}"]`);
                    
                    if (key === "Category") {
                        const optionElement = row.querySelector(`select[name="Category"] option[data-id="${value}"]`);
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