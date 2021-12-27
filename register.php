<?php
session_start();

include('class/database.php');
class signInUp extends database
{
    protected $link;
    public function signUpFunction()
    {
        if (isset($_POST['signup'])) {

            $agent_name = addslashes(trim($_POST['agent_name']));
            $pass = addslashes(trim($_POST['password']));



            $password = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "SELECT * from user_tbl where username = '$agent_name' ";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                $msg = "Agent Name is Taken!";
                return $msg;
            } else {
                $sql2 = "INSERT INTO `user_tbl` (`user_id`, `username`, `password`, `created_at`) VALUES (NULL, '$agent_name', '$password', CURRENT_TIMESTAMP)";
                $res2 = mysqli_query($this->link, $sql2);
                if ($res2) {


                    $_SESSION['name'] = $agent_name;

                    $msg = "Added";
                    return $msg;
                } else {
                    $msg = "Not Added";
                    return $msg;
                }
            }
        }
        # code...
    }
}
$obj = new signInUp;
$objSignUp = $obj->signUpFunction();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>

    <style>
    body {
        font-family: 'Lato', sans-serif;

    }

    .navbar-brand {
        width: 7%;
    }

    .bg_color {
        background-color: #fff !important;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5">

            <div class="row">


                <!-- <form action="" method="post"> -->
                <div class="col-md-6 offset-3 ">
                    <form action="" method="post" data-parsley-validate>

                        <div class="text-center">
                            <h4 class="font-weight-bold pt-5">SIGNUP</h4>

                            <?php if ($objSignUp) { ?>
                            <?php if (strcmp($objSignUp, 'Email taken') == 0) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>User is already taken!</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignUp, 'Email taken') == 1) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Invalid Information!</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignUp, 'Added') == 0) { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Congratulation!</strong> Profile is created!
                            </div>
                            <?php } ?>

                            <?php } ?>
                        </div>

                        <input type="text" name="agent_name" class="form-control mt-4 p-4 border-0 bg-light"
                            placeholder="Agent Name" required>
                        <input type="password" id="passwordField" class="form-control mt-4 p-4 border-0 bg-light"
                            name="password" placeholder="Password" required>

                        <button name="signup" type="submit"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SIGNUP</button>

                    </form>
                </div>
                <!-- </form> -->
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="js/datepicker.js"></script>
    <script>
    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        viewStart: 2,
        format: 'dd/mm/yyyy',

    });
    </script>
</body>

</html>