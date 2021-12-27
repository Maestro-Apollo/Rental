<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-light bg_color">
        <div class="container">
            <a class="navbar-brand font-weight-bold" style="font-family: 'Lato', sans-serif; color: #481639"
                href="index.php"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">

                    <?php if (isset($_SESSION['name'])) { ?>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="booking.php">Booking</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="booking-history.php">Booking History</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="booking-search.php">Booking Search</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="./password-reset.php">Reset Password</a>
                    </li>

                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="logout.php">Logout</a>
                    </li>

                    <?php } else if (isset($_SESSION['admin'])) { ?>

                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="admin-booking-history.php">Admin Booking
                            History</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="transaction-list.php">Transaction</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="./admin-booking-status.php">
                            Status & Comment</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="./create-staff.php">Create Staff</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="logout.php">Logout</a>
                    </li>
                    <?php } else { ?>

                    <li class="nav-item p-1">
                        <a class="nav-link text-white font-weight-bold" href="login.php">Login</a>
                    </li>
                    <?php } ?>







                </ul>

            </div>
        </div>
    </nav>
</div>