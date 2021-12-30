<?php
session_start();
if (isset($_SESSION['name'])) {
} else {
    header('location:login.php');
}
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
        background-color: #274472 !important;
    }
    </style>

</head>

<body class="bg-light">
    <?php include('layout/navbar.php'); ?>

    <section>
        <div class="container bg-white pr-4 pl-4  log_section pb-5">

            <div class="row">


                <!-- <form action="" method="post"> -->
                <div class="col-md-6 offset-lg-3 ">
                    <form id="myForm">

                        <div class="">
                            <h4 class="font-weight-bold pt-5 text-center">Enter New Booking</h4>
                            <div id="output2"></div>

                            <input type="text" name="property_name" class="form-control mt-4 p-4  bg-light"
                                placeholder="Property Name" required autocomplete="off">
                            <input type="text" class="form-control mt-4 p-4  bg-light" data-toggle="datepicker"
                                name="date" placeholder="Date" autocomplete="off" required>
                            <input type="number" name="agent_com" autocomplete="off"
                                class="form-control mt-4 p-4  bg-light" max="100" min="1" placeholder="Percentage (%)"
                                required>
                            <input type="text" autocomplete="off" name="rent" class="form-control mt-4 p-4  bg-light"
                                placeholder="Rent/Month" required>
                            <input type="text" autocomplete="off" name="land_com"
                                class="form-control mt-4 p-4  bg-light" placeholder="Commission from Landlord" required>
                            <input type="text" autocomplete="off" name="tenant_com"
                                class="form-control mt-4 p-4  bg-light" placeholder="Commission from Tenant" required>
                            <input type="text" autocomplete="off" class="form-control mt-4 p-4  bg-light"
                                name="agent_com_per" placeholder="Agent Comm.(Landlord)" required readonly>
                            <input type="text" autocomplete="off" class="form-control mt-4 p-4  bg-light"
                                name="tenant_com_per" placeholder="Agent Comm.(Tenant)" required readonly>
                            <input type="text" autocomplete="off" class="form-control mt-4 p-4  bg-light"
                                name="company_com" placeholder="TAC" required readonly>
                            <input type="text" autocomplete="off" class="form-control mt-4 p-4  bg-light" name="tcc"
                                placeholder="TCC" required readonly>
                            <textarea name="comment" placeholder="Comment" class="form-control mt-4  bg-light" id=""
                                cols="30" rows="3"></textarea>
                            <input class="multifile mt-4" type="file" name="booking_file[]">
                            <!-- <div class="pl-2 pr-2" id="output3">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="custom-file mt-4">
                                            <input type="file" name="booking_file[]" class="custom-file-input"
                                                id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-success mt-4" id="add"><i
                                                class="fas fa-plus"></i></button>
                                    </div>
                                </div>

                            </div> -->





                            <button name="signup" type="submit"
                                class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>

                    </form>
                </div>
                <!-- </form> -->
            </div>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="js/datepicker.js"></script>
    <script src="js/jquery.multifile.js"></script>
    <script src="js/jquery.multifile.preview.js"></script>
    <script>
    $('.multifile').multifile();
    </script>
    <script>
    $('[data-toggle="datepicker"]').datepicker({
        autoClose: true,
        autoHide: true,

        viewStart: 2,
        format: 'dd/mm/yyyy',

    });
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    </script>

    <script>
    let land_com = document.querySelector('input[name="land_com"]');
    let tenant_com = document.querySelector('input[name="tenant_com"]');
    let agent_com = document.querySelector('input[name="agent_com"]');

    agent_com.addEventListener('keyup', () => {
        let agent_com = document.querySelector('input[name="agent_com"]').value;
        let agent_com_per = ((land_com
            .value) === '') ? 0 : (document.querySelector('input[name="agent_com_per"]').value = parseFloat(
            ((
                parseFloat(
                    land_com
                    .value) * parseFloat(
                    agent_com)) / 100)));

        let tenant_com_per = ((tenant_com.value) === '') ? 0 : document.querySelector(
            'input[name="tenant_com_per"]').value = parseFloat(((
            parseFloat(
                tenant_com.value) * parseFloat(
                agent_com)) / 100));
        final_calc(agent_com_per, tenant_com_per);
        final_calc2(document.querySelector('input[name="land_com"]').value, document.querySelector(
            'input[name="tenant_com"]').value);
    });


    land_com.addEventListener('keyup', () => {
        // let agent_com_per = ;
        let agent_com = document.querySelector('input[name="agent_com"]').value;
        let agent_com_per = document.querySelector('input[name="agent_com_per"]').value = parseFloat(((
            parseFloat(
                land_com
                .value) * parseFloat(
                agent_com)) / 100));
        final_calc(agent_com_per, document.querySelector('input[name="tenant_com_per"]').value);
        final_calc2(document.querySelector('input[name="land_com"]').value, document.querySelector(
            'input[name="tenant_com"]').value);
    });

    tenant_com.addEventListener('keyup', () => {
        // let agent_com_per = ;

        let agent_com = document.querySelector('input[name="agent_com"]').value;
        let tenant_com_per = document.querySelector('input[name="tenant_com_per"]').value = parseFloat(((
            parseFloat(
                tenant_com.value) * parseFloat(
                agent_com)) / 100));
        final_calc(document.querySelector('input[name="agent_com_per"]').value, tenant_com_per);
        final_calc2(document.querySelector('input[name="land_com"]').value, document.querySelector(
            'input[name="tenant_com"]').value);


    });

    function final_calc(agent_com_per, tenant_com_per) {
        agent_com_per = (agent_com_per === '') ? 0 : parseFloat(agent_com_per);
        tenant_com_per = (tenant_com_per === '') ? 0 : parseFloat(tenant_com_per);
        document.querySelector('input[name="company_com"]').value = agent_com_per + tenant_com_per;
    }

    function final_calc2(a, b) {
        let agent_com = document.querySelector('input[name="agent_com"]').value;
        a = (a === '') ? 0 : parseFloat(a);
        b = (b === '') ? 0 : parseFloat(b);
        document.querySelector('input[name="tcc"]').value = (a + b) * (100 - agent_com) / 100;
    }
    </script>

    <script>
    $(document).ready(function() {

        $('#myForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "ajax-booking.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#output2').fadeIn().html(response);
                }
            });
            this.reset();
            $(".multifile_container").empty();

        });
    })
    </script>
    <!-- <script>
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#output3').prepend(
                '<div class="row" id="row' + i +
                '"><div class="col-10"><div class="custom-file mt-4"><input type="file" name="booking_file[]" class="custom-file-input" id="customFile' +
                i + '"><label class="custom-file-label" for="customFile' + i +
                '">Choose file</label></div></div><div class="col-2"><button type="button" name="remove" id="' +
                i +
                '" class="btn btn-danger mt-4 btn_remove"><i class="fas fa-minus"></i></button></div></div>'
            );

        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

    });
    </script> -->
</body>

</html>