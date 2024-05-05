<?php require_once "partials/header.php";

require_once "../controller/viewUserAccountController.php";
require_once "../controller/searchUserAccountController.php";
require_once "../controller/deleteUserAccountController.php";




if (isset($_GET['search'])) {
    $searchUserAccountController = new SearchUserAccountController();
    $allUsers = $searchUserAccountController->searchUsers($_GET['search']);
} else {
    $viewUserAccountController = new ViewUserAccountController();
    $allUsers = $viewUserAccountController->getUsers();
}

if (isset($_GET['delete_user'])) {
    deleteUser($_GET['delete_user']);
}

function deleteUser($username)
{
    $deleteUserController = new DeleteUserAccountController();
    $deleteUserController->deleteUser($username);
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
                <button type="button" class="btn btn-light">Create</button>
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
            // Iterate over the array and display each listing
            foreach ($allUsers as $user) {
            ?>
                <tr>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['contact'] ?></td>
                    <td><?= $user['profile'] ?></td>
                    <td><?= $user['status'] ?></td>
                    <td><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" style="cursor:pointer;">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0zM15 6l3 3m-5 11h8" />
                        </svg>
                        <a href="admin_manageAccounts.php?delete_user=<?php echo $user['username']; ?>" style="text-decoration: none; color: inherit;">
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

        <?php require_once "partials/footer.php"; ?>