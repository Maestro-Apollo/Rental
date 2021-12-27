<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Document</title>
    <?php include('layout/style.php'); ?>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    <style>
    body {
        font-family: 'Lato', sans-serif;

    }

    table.dataTable {
        border-collapse: collapse !important;
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
        <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4">
            <h4 class="font-weight-bold pt-5 text-center">Transaction</h4>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Agent</th>
                        <th>Property Name</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Paid by</th>
                        <th>Received by</th>
                        <th>Remarks</th>
                        <th>Copy of Slip</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>2011/04/25</td>
                        <td>Edinburgh</td>
                        <td>61</td>

                        <td>320800</td>
                        <td>320800</td>
                        <td>320800</td>
                        <td>320800</td>

                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>2011/07/25</td>

                        <td>Tokyo</td>
                        <td>63</td>
                        <td>170750</td>
                        <td>170750</td>
                        <td>170750</td>
                        <td>170750</td>

                    </tr>
                    <tr>
                        <td>Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>2009/01/12</td>

                        <td>San Francisco</td>
                        <td>66</td>
                        <td>86000</td>
                        <td>86000</td>
                        <td>86000</td>
                        <td>86000</td>

                    </tr>
                    <tr>
                        <td>Cedric Kelly</td>
                        <td>Senior Javascript Developer</td>
                        <td>2012/03/29</td>

                        <td>Edinburgh</td>
                        <td>22</td>
                        <td>433060</td>
                        <td>433060</td>
                        <td>433060</td>
                        <td>433060</td>

                    </tr>
                    <tr>
                        <td>Airi Satou</td>
                        <td>Accountant</td>
                        <td>2008/11/28</td>

                        <td>Tokyo</td>
                        <td>33</td>
                        <td>162700</td>
                        <td>162700</td>
                        <td>162700</td>
                        <td>162700</td>

                    </tr>
                    <tr>
                        <td>Brielle Williamson</td>
                        <td>Integration Specialist</td>
                        <td>2012/12/02</td>

                        <td>New York</td>
                        <td>61</td>
                        <td>372000</td>
                        <td>372000</td>
                        <td>372000</td>
                        <td>372000</td>

                    </tr>
                    <tr>
                        <td>Herrod Chandler</td>
                        <td>Sales Assistant</td>
                        <td>2012/12/02</td>

                        <td>San Francisco</td>
                        <td>59</td>
                        <td>137500</td>
                        <td>137500</td>
                        <td>137500</td>
                        <td>137500</td>

                    </tr>
                    <tr>
                        <td>Rhona Davidson</td>
                        <td>Integration Specialist</td>
                        <td>2010/10/14</td>

                        <td>Tokyo</td>
                        <td>55</td>
                        <td>327900</td>
                        <td>327900</td>
                        <td>327900</td>
                        <td>327900</td>

                    </tr>
                    <tr>
                        <td>Colleen Hurst</td>
                        <td>Javascript Developer</td>
                        <td>2009/09/15</td>

                        <td>San Francisco</td>
                        <td>39</td>
                        <td>205500</td>
                        <td>205500</td>
                        <td>205500</td>
                        <td>205500</td>

                    </tr>
                    <tr>
                        <td>Sonya Frost</td>
                        <td>Software Engineer</td>
                        <td>2008/12/13</td>

                        <td>Edinburgh</td>
                        <td>23</td>
                        <td>103600</td>
                        <td>103600</td>
                        <td>103600</td>
                        <td>103600</td>

                    </tr>
                    <tr>
                        <td>Donna Snider</td>
                        <td>Customer Support</td>
                        <td>2011/01/25</td>

                        <td>New York</td>
                        <td>27</td>
                        <td>112000</td>
                        <td>112000</td>
                        <td>112000</td>
                        <td>112000</td>

                    </tr>
                </tbody>

            </table>

        </div>

    </section>


    <?php include('layout/footer.php'); ?>

    <?php include('layout/script.php') ?>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.11.3/api/sum().js"></script>
    <script>
    // var table = $('#example').DataTable();
    // let tot = table.column(4).data().sum();
    // console.log(tot);
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,

        });


    });

    // $('#example').DataTable({
    //     drawCallback: function() {
    //         var api = this.api();
    //         $(api.table().footer()).html(
    //             api.column(4, {
    //                 page: 'current'
    //             }).data().sum()
    //         );
    //     }
    // });
    </script>
</body>

</html>