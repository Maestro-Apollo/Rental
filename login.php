<?php
session_start();



include('class/database.php');
class signInUp extends database
{
    protected $link;

    public function signInFunction()
    {
        if (isset($_POST['signIn'])) {
            $agent_name = $_POST['agent_name'];
            $password = $_POST['passwordLogIn'];

            $sql = "select * from user_tbl where username = '$agent_name' ";
            $res = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $pass = $row['password'];
                //password verify will check the hashed password from database and match with users password
                if (password_verify($password, $pass) == true) {
                    $_SESSION['name'] = $agent_name;
                    header('location:booking.php');
                    return $res;
                } else {
                    $msg = "Wrong password";
                    return $msg;
                }
            } else {
                $sql = "select * from admin_tbl where username = '$agent_name' ";
                $res = mysqli_query($this->link, $sql);

                if (mysqli_num_rows($res) > 0) {
                    $row = mysqli_fetch_assoc($res);
                    $pass = $row['password'];
                    //password verify will check the hashed password from database and match with users password
                    if (password_verify($password, $pass) == true) {
                        $_SESSION['admin'] = $agent_name;
                        header('location:admin-booking-history.php');
                        return $res;
                    } else {
                        $msg = "Wrong password";
                        return $msg;
                    }
                } else {
                    $msg = "Invalid Information";
                    return $msg;
                }
            }
        }
        # code...
    }
}
$obj = new signInUp;
$objSignIn = $obj->signInFunction();

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
        font-family: 'Raleway', sans-serif;
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

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5">

            <div class="row">
                <div class="col-md-6 offset-lg-3 ">

                    <form action="" method="post" data-parsley-validate>

                        <div class="text-center">

                            <!-- <button id="msg-btn" class="btn btn-success">Please check it</button> -->
                            <h4 class="font-weight-bold pt-5 pb-4">LOGIN</h4>


                            <?php if ($objSignIn) { ?>
                            <?php if (strcmp($objSignIn, 'Wrong password') == 0) { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Wrong Password!</strong>
                            </div>
                            <?php } ?>
                            <?php if (strcmp($objSignIn, 'Invalid Information') == 0) { ?>
                            <div class="alert alert-warning alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Please Sign Up!</strong>
                            </div>
                            <?php } ?>

                            <?php } ?>
                        </div>
                        <input type="text" name="agent_name" class="form-control p-4  border-0 bg-light"
                            placeholder="Enter your username name" required>
                        <input type="password" class="form-control mt-4 p-4 border-0 bg-light" name="passwordLogIn"
                            placeholder="Enter your password" required>


                        <button type="submit" name="signIn"
                            class="btn btn-block font-weight-bold log_btn btn-lg mt-4">LOGIN</button>



                    </form>
                </div>

                <!-- <form action="" method="post"> -->

                <!-- </form> -->
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>
    <!-- <script>
    $(document).ready(function() {
        $('#msg').hide();

        $('#msg-btn').click(function(e) {
            e.preventDefault();
            $('#msg').toggle();

        })
    })
    </script> -->
</body>

</html>