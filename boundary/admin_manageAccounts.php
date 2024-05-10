<?php require_once "partials/header.php";

require_once "../controller/adminViewUserAccountController.php";
require_once "../controller/adminSearchUserAccountController.php";
require_once "../controller/adminDeleteUserAccountController.php";
require_once "../controller/adminSuspendUserAccountController.php";
require_once "../controller/adminCreateUserAccountController.php";
require_once "../controller/adminUpdateUserAccountController.php";
require_once "../controller/adminViewProfileController.php";


$status = null;
$message = null;
$userAccount = null;
$allUsers = [];
$userProfiles = [];



if (isset($_POST["createUser"])) {
    $createUser = array();

    // store each field data in array
    foreach ($_POST as $key => $value) {
        $createUser[$key] = $value;
    }

    // create controller object
    $createUserController = new AdminCreateUserAccountController();
    $status = $createUserController->createUser($createUser);
    $message = $status === true ? 'User created successfully' : 'Error creating user';
    echo '<script>setTimeout(function() { window.location.href = "admin_manageAccounts.php"; }, 1000);</script>';
}

if (isset($_POST["updateUser"])) {
    $updateUser = array();

    // store each field data in array
    foreach ($_POST as $key => $value) {
        $updateUser[$key] = $value;
    }

    // create controller object
    $updateUserController = new AdminUpdateUserAccountController();
    $status = $updateUserController->updateUser($updateUser);
    $message = $status == true ? 'User updated successfully' : 'Error updating user';
    echo '<script>setTimeout(function() { window.location.href = "admin_manageAccounts.php"; }, 1000);</script>';
}

if (isset($_GET['search'])) {
    $searchUserAccountController = new AdminSearchUserAccountController();
    $allUsers = $searchUserAccountController->searchUsers($_GET['search']);
    $allProfiles = (new AdminViewProfileController())->getProfiles();
} else {
    $viewUserAccountController = new AdminViewUserAccountController();
    $allUsers = $viewUserAccountController->getUsers();
    $allProfiles = (new AdminViewProfileController())->getProfiles();
}

if (isset($_GET['delete_user'])) {
    deleteUser($_GET['delete_user']);
    $_GET = array();
}

if (isset($_GET['suspend_user'])) {
    suspendUser($_GET['suspend_user']);
    $_GET = array();
}

function deleteUser($username)
{
    global $status, $message;
    $deleteUserController = new AdminDeleteUserAccountController();
    $status = $deleteUserController->deleteUser($username);
    $message = $status ? 'User deleted successfully' : 'Error deleting user';

    echo '<script>setTimeout(function() { window.location.href = "admin_manageAccounts.php"; }, 1000);</script>';
}

function suspendUser($username)
{
    global $status, $message;
    $suspendUser = new AdminSuspendUserAccountController();
    $status = $suspendUser->suspendUser($username);
    $message = $status ? 'User suspended successfully' : 'Error suspending user';

    echo '<script>setTimeout(function() { window.location.href = "admin_manageAccounts.php"; }, 1000);</script>';
}

?>

<br>

<!-- DISPLAY Users -->
<?php
// Check if $allListing is empty
if (!isset($allUsers)) {
    echo "Users are not set";
} else {
    // Open the row div
    if (isset($status) && isset($message)) {
        if ($status === true) {
?>
            <div class="alert alert-success alert-dismissible fade show m-2" role="alert">
                <?php echo $message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <?php

        } else {
        ?>
            <div class="alert alert-danger alert-dismissible fade show m-2" role="alert">
                <?php echo $message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    <?php
        }
    }
    ?>

    <div style="margin: 10px; ">
        <div class="row between-xs mb-3">
            <div class="col-xs-6 col-md-8">
                <form action="admin_manageAccounts.php" method="get">
                    <div class="input-group rounded">
                        <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

            </div>
            <div class="col-xs-6 col-md-4 d-flex justify-content-end">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#createUser">Create</button>
            </div>
        </div>

        <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserLabel">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <form action="admin_manageAccounts.php" method="post">
                            <div class="form-group">
                                <label for="fullname">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" maxlength="255" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" maxlength="255" required>
                            </div>
                            <div class="form-group">
                                <label for="profile">Select profile</label>
                                <select class="form-control" id="profile" name="profile" required>
                                    <?php
                                    foreach ($allProfiles as $profile) {
                                    ?>
                                        <tr>
                                            <option value=<?php echo $profile['profile_name'] ?>><?= $profile['profile_name'] ?></option>
                                        <?php
                                    }
                                        ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active">active</option>
                                    <option value="suspended">suspended</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="tel" id="contact" class="form-control" name="contact">
                            </div>
                            <div class="form-group">
                                <label for="password" class="mb-0">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="modal-footer ">
                                <input type="submit" class="btn btn-primary" value="Submit" name="createUser" <?php if (isset($status) && $status) {
                                                                                                                    echo "data-dismiss='modal'";
                                                                                                                } ?>>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>



    </div>

    <table class="table">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Profile</th>
            <th>Status</th>
            <th>Actions</th>

        </tr>
        <?php
        foreach ($allUsers as $user) {
        ?>
            <tr>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['contact'] ?></td>
                <td><?= $user['profile'] ?></td>
                <td><?= $user['status'] ?></td>
                <td>
                    <svg xmlns="http://www.w3.org/2000/svg" data-toggle="modal" data-target="#updateUser" width="1em" height="1em" viewBox="0 0 24 24" style="cursor:pointer;" onclick="setUser('<?php echo htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8'); ?>')">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0zM15 6l3 3m-5 11h8" />
                    </svg>
                    <a href="admin_manageAccounts.php?suspend_user=<?php echo $user['username']; ?>" style="text-decoration: none; color: inherit;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" style="cursor:pointer;">
                            <path fill="currentColor" d="M12 1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12S5.925 1 12 1M2.5 12a9.5 9.5 0 0 0 9.5 9.5a9.5 9.5 0 0 0 9.5-9.5A9.5 9.5 0 0 0 12 2.5A9.5 9.5 0 0 0 2.5 12m15.75.75H5.75a.75.75 0 0 1 0-1.5h12.5a.75.75 0 0 1 0 1.5" />
                        </svg>
                    </a>
                    </form>
                    <a href="admin_manageAccounts.php?delete_user=<?php echo $user['username']; ?>" style="text-decoration: none; color: inherit;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256" style="cursor:pointer;">
                            <path fill="currentColor" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16M96 40a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8v8H96Zm96 168H64V64h128Zm-80-104v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0m48 0v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0" />
                        </svg>
                    </a>
                </td>

            </tr>

    <?php
        }
        // Close the row div
        echo '</table></div>'; // Close .row

    }
    ?>
    <div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-labelledby="UpdateUserLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateUserLabel">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <form action="admin_manageAccounts.php" method="post">
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" class="form-control" id="edit_fullname" name="fullname" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="username" maxlength="100" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of birth</label>
                            <input type="date" class="form-control" id="edit_dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="edit_email" name="email" placeholder="Enter email" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="profile">Select profile</label>
                            <select class="form-control" id="edit_profile" name="profile" required>
                                <?php
                                foreach ($allProfiles as $profile) {
                                ?>
                                    <tr>
                                        <option value=<?php echo $profile['profile_name'] ?>><?= $profile['profile_name'] ?></option>
                                    <?php
                                }
                                    ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="active">active</option>
                                <option value="suspended">suspended</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact</label>
                            <input type="tel" id="edit_contact" class="form-control" name="contact">
                        </div>
                        <div class="form-group">
                            <label for="password" class="mb-0">New Password</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="account_id" name="account_id">
                        </div>
                        <div class="modal-footer ">
                            <input type="submit" class="btn btn-primary" value="Submit" name="updateUser" <?php if (isset($status) && $status) {
                                                                                                                echo "data-dismiss='modal'";
                                                                                                            } ?>>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>
    <script>
        var userData;

        function setUser(user) {
            userData = JSON.parse(user);
            console.log(userData.account_id)
            document.getElementById('edit_profile').value = userData.profile;
            document.getElementById('edit_fullname').value = userData.fullname;
            document.getElementById('edit_username').value = userData.username;
            document.getElementById('edit_dob').value = userData.dob;
            document.getElementById('edit_email').value = userData.email;
            document.getElementById('edit_status').value = userData.status;
            document.getElementById('edit_contact').value = userData.contact;
            document.getElementById('account_id').value = userData.account_id;
        }
    </script>


    <?php require_once "partials/footer.php"; ?>