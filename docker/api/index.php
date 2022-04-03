<?php
$modals = file_get_contents('modals.html', true);
$Sidebar = file_get_contents('Sidebar.html', true);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Barcode</title>

    <!--<meta name="viewport" content="width=device-width, initial-scale=1.5">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    

    <!-- Fontawsome  -->
    <link rel="stylesheet" type="text/css" href="./fontawsome/css/all.css">

    <!-- Jquery  -->
    <script type="text/javascript" src="js/jquery.min.js"></script>

    <!-- Jquery resizableColumns -->
    <link rel="stylesheet" type="text/css" href="css/jquery.resizableColumns.css"></link>

    <!-- Solidjs  -->
    <script type="text/javascript" src="js/solid.min.js"></script>

    <!-- PopperJS  -->
    <script type="text/javascript" src="js/popper.min.js"></script>

    <!-- Slimselect  -->
    <link rel="stylesheet" type="text/css" href="css/slimselect.min.css" />
    <script type="text/javascript" src="js/slimselect.min.js"></script>

    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="css/datatables.min.css" />
    <script type="text/javascript" src="js/datatables.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <!-- bootstrap Table -->
    <link rel="stylesheet" href="css/dragtable.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-table.min.css" />
    <script type="text/javascript" src="js/jquery.resizableColumns.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.dragtable.js"></script>
    <script type="text/javascript" src="js/bootstrap-table.min.js"></script>


    <script type="text/javascript" src="js/bootstrap-table-reorder-columns.min.js"></script>


    <!-- bootstrap Table sticky-header -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap-table-sticky-header.css" />
    <script type="text/javascript" src="js/bootstrap-table-sticky-header.min.js"></script>


    <!-- bootstrap Icons -->
    <link rel="stylesheet" type="text/css" href="bootstrap-icons/bootstrap-icons.css">

    <!-- bootstrap Table filter-control -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap-table-filter-control.min.css" />
    <script type="module" src="js/bootstrap-table-filter-control.min.js"></script>
    
    <!-- bootstrap Table export -->
    
    <script type="text/javascript" src="js/bootstrap-table-export.min.js"></script>


    <!-- bootstrap Table addrbar -->
    <script type="text/javascript" src="js/bootstrap-table-addrbar.min.js"></script>
    

    <!-- bootstrap Table resizable -->
    <script type="text/javascript" src="js/bootstrap-table-resizable.min.js"></script>


    <!-- bootstrap-datepicker  -->
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.min.css" />

    <!-- Jquery TableExport -->
    <script type="text/javascript" src="js/tableExport.min.js"></script>

    <!-- Toastr  -->
    <link rel="stylesheet" type="text/css" href="css/toastr.min.css" />
    <script type="text/javascript" src="js/toastr.min.js"></script>

    <!-- dygraphs  -->
    <script type="text/javascript" src="js/dygraph.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/dygraph.min.css" />

    <!-- Google Charts  -->
    <script type="text/javascript" src="js/google_charts.js"></script>
    <script type="text/javascript" src="js/charts.js"></script>

    <!-- Moment  -->
    <script type="text/javascript" src="js/moment-with-locales.js"></script>

    <!-- JSON Editor  -->
    <link rel="stylesheet" type="text/css" href="css/jsoneditor.min.css" />
    <script type="text/javascript" src="js/jsoneditor.min.js"></script>



    

    <!-- Main CSS-->
    <link rel="stylesheet" href="css/main.css?version=5">



  </head>

  <body>


    <div class="wrapper">
      <!-- Sidebar -->
          <?php echo $Sidebar;?>
    
        
    <?php echo $modals;?>
    <div id="content"></div>
  </body>


</html>


<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/SideBar.js"></script>
<script type="text/javascript" charset="UTF-8" >



  $(document).ready(function () {

    if (window.location.hash == "") {
      document.getElementById("#barcode").click();
    } else {
      try {
        document.getElementById(window.location.hash).click();
      } catch (error) {
        document.getElementById("#barcode").click();
      
      }
    }

    if (
      /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
        navigator.userAgent
      )
    ) {
      var lis = document.querySelectorAll("#prodTabs li");
      for (var i = 0;
        (li = lis[i]); i++) {

        if (li.id == "lisidebarCollapse") {
          li.parentNode.removeChild(li);
        }
      }
    }
    $("#sidebar").toggleClass("active");
  });

  SidebarCollapse();



  function displayContent() {
    $("#content").html(this.responseText);
  }



</script>