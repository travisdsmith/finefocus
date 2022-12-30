<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Fine Focus</title>

        <link rel="icon" href="../assets/favicon.png" type="image/x-icon">

        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom Styles -->
        <link href="../css/custom.css" rel="stylesheet">

        <!-- IE Fonts -->
        <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="../styles/iefonts.css">
        <![endif]-->

        <!-- Font Awesome -->
        <link href="../css/font-awesome.min.css" rel="stylesheet">

        <style>
            html, body{height:100%; margin:0;padding:0}

            .container-fluid{
                height:100%;
                display:table;
                width: 100%;
                padding: 0;
                margin-top: -10px;
            }

            .row-fluid {height: 100%; display:table-cell; vertical-align: middle;}

            .centering {
                float:none;
                margin:0 auto;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid fixed-width">
            <div class="row-fluid">
                <div class="centering text-center">
                    <img src="../assets/main.png" alt="Logo">
                    <p style="font-size: 60px; font-family: 'Champagne & Limousines'; margin-top: -10px;">
                        <em>Fine Focus</em> Journal
                    </p>
                    <?php if (filter_input(INPUT_POST, "submit")) { ?>
                        <p style="font-size: 24px; font-family: 'Champagne & Limousines'">
                            <?php echo filter_input(INPUT_POST, "conference_name") ?> &bull; <?php echo filter_input(INPUT_POST, "date") ? filter_input(INPUT_POST, "date") : strftime("%A, %B  %d, %Y", time()); ?>
                        </p>
                        <p>
                            <a href='conference_journal.php' class="btn btn-lg btn-default">Request a Journal</a>
                            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#info">
                                Request More Information
                            </button>
                            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#website">
                                Visit our Website
                            </button>
                        </p>
                        <div class="modal fade" id="website" tabindex="-1" role="dialog" aria-labelledby="Visit our Website">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="websiteLabel">FineFocus.org</h4>
                                    </div>
                                    <div class="modal-body">
                                        <iframe src="../index.php" width=100% height=80%; style="border:none"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="Request More Information">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="infoLabel">Request More Information</h4>
                                    </div>
                                    <div class="modal-body">
                                        <iframe src="../journals.php" width=100% height=80% style="border:none"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <p style="font-size: 36px; font-family: 'Champagne & Limousines'">
                            FineFocus.org Kiosk Mode
                        </p>
                        <form action="index.php" method='POST' class="form-horizontal">
                            <div class="form-group">
                                <label for="conference_name" class="col-sm-2 control-label">Conference</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="conference_name" name="conference_name" placeholder="(required)" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date" class="col-sm-2 control-label">Date</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="date" name="date" placeholder="<?= date("l, F  j, Y") ?>">
                                </div>
                            </div>
                            <div>
                                <input class="btn btn-default btn-lg" type="submit" name="submit" id="submit" value="Continue">
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>