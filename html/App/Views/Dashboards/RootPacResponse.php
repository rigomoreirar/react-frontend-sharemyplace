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

<h2>PAC Response Table Root</h2>

<form action="/dashboard_root/pac_response_table/add_pac_response" method="post"> 
  <div class="container">
    <button type="submit">Add new PAC Response</button>
  </div>
</form>
<!-- User Table -->
<table id="pacResponseTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>PAC Response Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pacResponses as $pacResponse): ?>
        <tr>
            <td>
                <span class="editable" data-name="Name"><?= $pacResponse['Name'] ?></span>
                <input name="id" class="inputField hidden" type="hidden" value="<?= $pacResponse['id'] ?>">
                <input name="Name" class="inputField hidden" type="text" value="<?= $pacResponse['Name'] ?>">
            </td>
            <td>
                <span class="editable" data-name="Description"><?= $pacResponse['Description'] ?></span>
                <input name="id" class="inputField hidden" type="hidden" value="<?= $pacResponse['id'] ?>">
                <input name="Description" class="inputField hidden" type="text" value="<?= $pacResponse['Description'] ?>">
            </td>

            <td>
                <span class="editable" data-name="PACStatus"><?= $pacResponse['PACStatus'] ? 'True' : 'False' ?></span>
                <select name="PACStatus" class="inputField hidden">
                    <option value="True" <?= $pacResponse['PACStatus'] ? 'selected' : '' ?>>True</option>
                    <option value="False" <?= !$pacResponse['PACStatus'] ? 'selected' : '' ?>>False</option>
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

document.getElementById('pacResponseTable').addEventListener('click', function(event) {
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
            body: JSON.stringify({ type: 'pacResponseTable', data })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                toggleEditMode(row, false);
                Object.entries(data).forEach(([key, value]) => {
                    const editable = row.querySelector(`.editable[data-name="${key}"]`);
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