<?php

/*
* General Setting Single CMS PageTemplate
*
*
*/
?>

<?php
ob_start();
include('includes/header.php');
include("includes/demo_conn.php");

// Define target directory
$target_dir = __DIR__ . '/images/';

$id = $_GET['id'] ?? null;
$website_name = '';
$website_url = '';
$phone_no = [];
$whatsapp_no = [];
$email_id = [];

// Fetch existing setting for displaying in the form
$options = [];
$query = $conn->query("SELECT option_name, option_value FROM setting");
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $options[$row['option_name']] = $row['option_value'];
}

// Assign existing values to variables
$website_name = htmlspecialchars($options['website_name'] ?? '');
$website_url = htmlspecialchars($options['website_url'] ?? '');
$phone_no = !empty($options['phone_no']) ? explode(', ', $options['phone_no']) : [];
$whatsapp_no = !empty($options['whatsapp_no']) ? explode(', ', $options['whatsapp_no']) : [];
$email_id = !empty($options['email_id']) ? explode(', ', $options['email_id']) : [];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $website_name = $_POST['website_name'] ?? '';
    $website_url = $_POST['website_url'] ?? '';
    $phone_no = $_POST['phone_no'] ?? [];
    $whatsapp_no = $_POST['whatsapp_no'] ?? [];
    $email_id = $_POST['email_id'] ?? [];

    $phone_no_string = implode(', ', $phone_no);
    $whatsapp_no_string = implode(', ', $whatsapp_no);
    $email_id_string = implode(', ', $email_id);

    // if ($action == 'save' || $action == 'update') {
        // Prepare to insert or update records
        $queries = [
            ['option_name' => 'website_name', 'option_value' => $website_name],
            ['option_name' => 'website_url', 'option_value' => $website_url],
            ['option_name' => 'phone_no', 'option_value' => $phone_no_string],
            ['option_name' => 'whatsapp_no', 'option_value' => $whatsapp_no_string],
            ['option_name' => 'email_id', 'option_value' => $email_id_string],
        ];

        foreach ($queries as $data) {
            $query = $conn->prepare("UPDATE setting SET option_value = :option_value WHERE option_name = :option_name");
            $result = $query->execute($data);
        }

        echo $result ? "Save Successful" : "Save Unsuccessful";
    // }
}
?>


<div class="container">
    <h2><b>General Setting</b></h2>
    <div class="row">
        <div class="main">
            <div class="card">
                <div class="card-header">
                    <h5 class="font-weight-bold text-primary mt-2">Website Details</h5>
                </div>
                <div class="card-body">
                    <form id="setting" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <!-- Website Name -->
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="website_name" class="form-label">Website Name</label>
                                <input class="form-control" name="website_name" id="website_name" placeholder="Name" value="<?= $website_name ?>">
                            </div>
                        </div>

                        <!-- Website URL -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="website_url" class="form-label">Website Url</label>
                                <input class="form-control" name="website_url" id="website_url" placeholder="URL" value="<?= $website_url ?>">
                            </div>
                        </div>

                        <!-- Phone Numbers -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Phone No.</label>
                                <div id="phone-container">
                                    <?php foreach ($phone_no as $index => $phone): ?>
                                        <div class="add-table mb-3 cloned-row">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text"><?= $index + 1 ?>.</span>
                                                <input type="text" class="form-control" name="phone_no[]" value="<?= htmlspecialchars($phone) ?>">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-phone">Remove</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="add-table mb-3 cloned-row">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><?= count($phone_no) + 1 ?>.</span>
                                            <input type="text" class="form-control" name="phone_no[]">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-phone">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm" id="add-phone">
                                    <i class="fas fa-plus"></i> Add Phone No
                                </button>
                            </div>

                            <!-- Whatsapp Numbers -->
                            <div class="col-md-6">
                                <label>Whatsapp No.</label>
                                <div id="whatsapp-container">
                                    <?php foreach ($whatsapp_no as $index => $whatsapp): ?>
                                        <div class="add-table mb-3 cloned-row">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text"><?= $index + 1 ?>.</span>
                                                <input type="text" class="form-control" name="whatsapp_no[]" value="<?= htmlspecialchars($whatsapp) ?>">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-whatsapp">Remove</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="add-table mb-3 cloned-row">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><?= count($whatsapp_no) + 1 ?>.</span>
                                            <input type="text" class="form-control" name="whatsapp_no[]">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-whatsapp">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm" id="add-whatsapp">
                                    <i class="fas fa-plus"></i> Add Whatsapp No
                                </button>
                            </div>
                        </div>

                        <!-- Emails -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Email Id </label>
                                <div id="email-container">
                                    <?php foreach ($email_id as $index => $emails): ?>
                                        <div class="add-table mb-3 cloned-row">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text"><?= $index + 1 ?>.</span>
                                                <input type="text" class="form-control" name="email[]" value="<?= htmlspecialchars($emails) ?>">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-email">Remove</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="add-table mb-3 cloned-row">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text"><?= count($email_id) + 1 ?>.</span>
                                            <input type="text" class="form-control" name="email[]">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-email">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm" id="add-email">
                                    <i class="fas fa-plus"></i> Add Email Id
                                </button>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <!-- <input type="hidden" name="action" value="<?= $id ? 'update' : 'save' ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                        <?php endif; ?> -->
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    
                    <!-- Delete Setting Button -->
                    <?php if ($id): ?>
                        <div class="mt-3">
                            <a href="?action=delete&id=<?= urlencode($id) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this setting?');">
                                Delete
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

document.addEventListener('DOMContentLoaded', () => {
    const addPhoneBtn = document.getElementById('add-phone');
    const addWhatsappBtn = document.getElementById('add-whatsapp');
    const addEmailBtn = document.getElementById('add-email');
    const phoneContainer = document.getElementById('phone-container');
    const whatsappContainer = document.getElementById('whatsapp-container');
    const emailContainer = document.getElementById('email-container');
    
    // Add phone number fields
    addPhoneBtn.addEventListener('click', () => {
        const index = phoneContainer.children.length + 1;
        const newRow = document.createElement('div');
        newRow.classList.add('add-table', 'mb-3', 'cloned-row');
        newRow.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text">${index}.</span>
                <input type="text" class="form-control" name="phone_no[]">
                <button type="button" class="btn btn-outline-danger btn-sm remove-phone">Remove</button>
            </div>
        `;
        phoneContainer.appendChild(newRow);
    });

    // Remove phone number fields
    phoneContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-phone')) {
            e.target.closest('.cloned-row').remove();
        }
    });

    // Add whatsapp number fields
    addWhatsappBtn.addEventListener('click', () => {
        const index = whatsappContainer.children.length + 1;
        const newRow = document.createElement('div');
        newRow.classList.add('add-table', 'mb-3', 'cloned-row');
        newRow.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text">${index}.</span>
                <input type="text" class="form-control" name="whatsapp_no[]">
                <button type="button" class="btn btn-outline-danger btn-sm remove-whatsapp">Remove</button>
            </div>
        `;
        whatsappContainer.appendChild(newRow);
    });

    // Remove whatsapp number fields
    whatsappContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-whatsapp')) {
            e.target.closest('.cloned-row').remove();
        }
    });

    // Add email fields
    addEmailBtn.addEventListener('click', () => {
        const index = emailContainer.children.length + 1;
        const newRow = document.createElement('div');
        newRow.classList.add('add-table', 'mb-3', 'cloned-row');
        newRow.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text">${index}.</span>
                <input type="text" class="form-control" name="email_id[]">
                <button type="button" class="btn btn-outline-danger btn-sm remove-email">Remove</button>
            </div>
        `;
        emailContainer.appendChild(newRow);
    });

    // Remove email fields
    emailContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-email')) {
            e.target.closest('.cloned-row').remove();
        }
    });
});
</script>

<?php include('includes/footer.php'); ?>
