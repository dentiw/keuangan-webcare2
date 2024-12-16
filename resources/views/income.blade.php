<?php
session_start();

// Dummy Data Initialization
if (!isset($_SESSION['income'])) {
    $_SESSION['income'] = [
        [
            'no' => 1,
            'date' => 'Thursday, October 24th 2024',
            'source' => 'Web Project',
            'amount' => 'Rp. 750.000'
        ],
        [
            'no' => 2,
            'date' => 'Thursday, October 24th 2024',
            'source' => 'Doorprize',
            'amount' => 'Rp. 500.000'
        ],
        [
            'no' => 3,
            'date' => 'Thursday, October 24th 2024',
            'source' => 'Design Project',
            'amount' => 'Rp. 1.250.000'
        ],
    ];
}

// Handle Add Action
if (isset($_POST['add'])) {
    $new_income = [
        'no' => count($_SESSION['income']) + 1,
        'date' => $_POST['date'],
        'source' => $_POST['source'],
        'amount' => $_POST['amount']
    ];
    $_SESSION['income'][] = $new_income;
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}

// Handle Delete Action
if (isset($_GET['delete'])) {
    $delete_no = $_GET['delete'];
    foreach ($_SESSION['income'] as $key => $income) {
        if ($income['no'] == $delete_no) {
            unset($_SESSION['income'][$key]);
            $_SESSION['income'] = array_values($_SESSION['income']);
            break;
        }
    }
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}

// Handle Edit Action
if (isset($_POST['edit'])) {
    $edit_no = $_POST['edit_no'];
    foreach ($_SESSION['income'] as $key => &$income) {
        if ($income['no'] == $edit_no) {
            $income['date'] = $_POST['date'];
            $income['source'] = $_POST['source'];
            $income['amount'] = $_POST['amount'];
            break;
        }
    }
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .sidebar {
            width: 250px;
            background-color: #1a73e8;
            color: white;
            position: fixed;
            height: 100%;
            padding: 20px 10px;
        }
        .sidebar a {
            color: white;
            display: flex;
            align-items: center;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover { background-color: #0c47a1; border-radius: 5px; }
        .content { margin-left: 270px; padding: 20px; }
        table thead { background-color: #1a73e8; color: white; }
        .btn-add-data { position: absolute; bottom: 30px; right: 30px; }
        .icon-action { font-size: 1rem; }
        .form-container { max-width: 400px; margin: 20px auto; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Client Portal</h4>
        <a href="#"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a href="#"><i class="fas fa-user-friends me-2"></i> Client</a>
        <a href="#"><i class="fas fa-video me-2"></i> Video Tutorial</a>
        <a href="#"><i class="fas fa-user me-2"></i> User</a>
        <a href="#"><i class="fas fa-file-invoice-dollar me-2"></i> Financial Statements</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h3>Financial Statements / Income</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Source of Funds</th>
                    <th>Amount of Money</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['income'] as $income): ?>
                    <tr>
                        <td><?php echo $income['no']; ?></td>
                        <td><?php echo $income['date']; ?></td>
                        <td><?php echo $income['source']; ?></td>
                        <td><?php echo $income['amount']; ?></td>
                        <td>
                            <a href="?delete=<?php echo $income['no']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash icon-action"></i></a>
                            <button class="btn btn-success btn-sm" onclick="editData(<?php echo htmlspecialchars(json_encode($income)); ?>)"><i class="fas fa-pen icon-action"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-primary btn-add-data" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Add Data</button>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Income</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="edit_no" id="edit_no">
                        <label>Date:</label>
                        <input type="text" name="date" id="date" class="form-control" required>
                        <label>Source:</label>
                        <input type="text" name="source" id="source" class="form-control" required>
                        <label>Amount:</label>
                        <input type="text" name="amount" id="amount" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add" id="btnAdd" class="btn btn-primary">Add</button>
                        <button type="submit" name="edit" id="btnEdit" class="btn btn-success d-none">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editData(income) {
            document.getElementById('modalTitle').innerText = 'Edit Income';
            document.getElementById('edit_no').value = income.no;
            document.getElementById('date').value = income.date;
            document.getElementById('source').value = income.source;
            document.getElementById('amount').value = income.amount;
            document.getElementById('btnAdd').classList.add('d-none');
            document.getElementById('btnEdit').classList.remove('d-none');
            var editModal = new bootstrap.Modal(document.getElementById('addModal'));
            editModal.show();
        }
    </script>
</body>
</html>
