<?php require_once "partials/header.php";

require_once "../controller/adminViewProfileController.php";
require_once "../controller/adminSearchProfileController.php";
require_once "../controller/adminDeleteProfileController.php";
require_once "../controller/adminCreateProfileController.php";
require_once "../controller/adminUpdateProfileController.php";

$status = null;
$message = null;
$allProfiles = [];


//to get profileprofile from profile controller 

if (isset($_POST["createProfile"])) {
    $createProfile = array();

    // store each field data in array
    foreach ($_POST as $key => $value) {
        $createProfile[$key] = $value;
    }

    // create controller object
    $createProfileController = new AdminCreateProfileController();
    $status = $createProfileController->createProfile($createProfile);
    $message = $status == true ? 'Profile created successfully' : 'Error creating profile';

    echo '<script>setTimeout(function() { window.location.href = "admin_manageAccounts.php"; }, 1000);</script>';
}

if (isset($_POST["updateProfile"])) {
    $updateProfile = array();

    // store each field data in array
    foreach ($_POST as $key => $value) {
        $updateProfile[$key] = $value;
    }

    // create controller object
    $updateProfileController = new AdminUpdateProfileController();
    $status = $updateProfileController->updateProfile($updateProfile);
    $message = $status == true ? 'Profile updated successfully' : 'Error updating profile';
  
    echo '<script>setTimeout(function() { window.location.href = "admin_manageProfiles.php"; }, 1000);</script>';
}

if (isset($_GET['search'])) {
    $searchProfileController = new AdminSearchProfileController();
    $allProfiles = $searchProfileController->searchProfiles($_GET['search']);
} else {
    $viewProfileController = new AdminViewProfileController();
    $allProfiles = $viewProfileController->getProfiles();
}

if (isset($_GET['delete_profile'])) {
    deleteProfile($_GET['delete_profile']);
    $_GET = array();

}

function deleteProfile($profilename)
{
    global $status, $message;
    $deleteProfileController = new AdminDeleteProfileController();
    $status = $deleteProfileController->deleteProfile($profilename);
    $message = $status ? 'Profile deleted successfully' : 'Error deleting profile';

    echo '<script>setTimeout(function() { window.location.href = "admin_manageProfiles.php"; }, 1000);</script>';

}

?>

<br>

<!-- DISPLAY Profiles -->
<?php
// Check if $allListing is empty
if (!isset($allProfiles)) {
    echo "Profiles are not set";
} else {
    // Open the row div
    if (isset($status) && isset($message)) {
        if ($status == true) {
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
                <form action="admin_manageProfiles.php" method="get">
                    <div class="input-group rounded">
                        <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

            </div>
            <div class="col-xs-6 col-md-4 d-flex justify-content-end">
                <button type="button" class="btn btn-light" data-toggle="modal" data-target="#createProfile">Create</button>
            </div>
        </div>

        <div class="modal fade" id="createProfile" tabindex="-1" role="dialog" aria-labelledby="createProfileLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProfileLabel">Create Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <form action="admin_manageProfiles.php" method="post">
                            <div class="form-group">
                                <label for="profile_name">Profile Name</label>
                                <input type="text" class="form-control" id="profile_name" name="profile_name" maxlength="100" required>
                            </div>

                            <div class="form-group">
                                <label for="dob">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            
                            <div class="modal-footer ">
                                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                <input type="submit" class="btn btn-primary" value="Submit" name="createProfile" <?php if (isset($status) && $status) {
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
            <th>Profile Name</th>
            <th>Description</th>
            <th>Actions</th>

        </tr>
        <?php
        // Iterate over the array and display each listing
        foreach ($allProfiles as $profile) {
        ?>
            <tr>
                <td><?= $profile['profile_name'] ?></td>
                <td><?= $profile['description'] ?></td>
                <td>
                    <svg xmlns="http://www.w3.org/2000/svg" data-toggle="modal" data-target="#updateProfile" width="1em" height="1em" viewBox="0 0 24 24" style="cursor:pointer;" onclick="setProfile('<?php echo htmlspecialchars(json_encode($profile), ENT_QUOTES, 'UTF-8'); ?>')">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m5 16l-1 4l4-1L19.586 7.414a2 2 0 0 0 0-2.828l-.172-.172a2 2 0 0 0-2.828 0zM15 6l3 3m-5 11h8" />
                    </svg>
                    <a href="admin_manageProfiles.php?delete_profile=<?php echo $profile['profile_name']; ?>" style="text-decoration: none; color: inherit;">
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
    <div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-labelledby="UpdateProfileLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileLabel">Update Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <form action="admin_manageProfiles.php" method="post">
                        <div class="form-group">
                            <label for="profile_name">Profile Name</label>
                            <input type="text" class="form-control" id="edit_profile_name" name="profile_name" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="profile_id" name="profile_id">
                        </div>
                        <div class="modal-footer ">
                            <input type="submit" class="btn btn-primary" value="Submit" name="updateProfile" <?php if (isset($status) && $status) {
                                                                                                                echo "data-dismiss='modal'";
                                                                                                            } ?>>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>
    <script>
        var profileData;

        function setProfile(profile) {
            profileData = JSON.parse(profile);
            console.log(profileData.profile_id)
            document.getElementById('edit_profile_name').value = profileData.profile_name;
            document.getElementById('edit_description').value = profileData.description;
            document.getElementById('profile_id').value = profileData.profile_id;
        }
    </script>


    <?php require_once "partials/footer.php"; ?>