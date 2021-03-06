<?php
   include 'includes/head.php';
   include 'includes/header.php';
   ?>
<head>
   <title>Mutes/TempMutes - <?php echo $name; ?></title>
</head>
<?php
    // <<-----------------Database Connection------------>> //
    require 'includes/data/database.php';
    $sql = 'SELECT * FROM Punishments WHERE punishmentType = "MUTE" || "TEMP_MUTE" ORDER BY start DESC LIMIT 20;';
    $retval = $conn->query($sql);
?>
<body
<body>
   <div class="container content">
      <div class="row">
         <div class="col-lg-12">
            <h1 class="page-header">Mutes</h1>
            <table class="table table-hover table-bordered table-condensed">
            <thead>
               <tr>
                  <th>
                     <center>Name</center>
                  </th>
                  <th>
                     <center>Muted By</center>
                  </th>
                  <th>
                     <center>Reason</center>
                  </th>
                  <th>
                     <center>Muted On</center>
                  </th>
                  <th>
                     <center>Muted Until</center>
                  </th>
               </tr>
            </thead>
            <tbody>
            <?php while($row = $retval->fetch_assoc()) {
                if($row['operator'] == null) {
                    $row['operator'] = 'Console';
                }
                // <<-----------------Mute Date Converter------------>> //
                $timeEpoch = $row['start'];
                $timeConvert = $timeEpoch / 1000;
                $timeResult = date('F j, Y, g:i a', $timeConvert);
                // <<-----------------Expiration Time Converter------------>> //
                $expiresEpoch = $row['end'];
                $expiresConvert = $expiresEpoch / 1000;
                $expiresResult = date('F j, Y, g:i a', $expiresConvert);
                ?>
                <tr>
                    <td>
                        <?php
                        echo "<img src='https://mcapi.ca/avatar/2d/" . $row['name'] . "/25' style='margin-bottom:5px;margin-right:5px;border-radius:2px;' />" . $row['name'];
                        ?></td>
                    <td>
                        <?php
                        echo "<img src='https://mcapi.ca/avatar/2d/" . $row['operator'] . "/25'  style='margin-bottom:5px;margin-right:5px;border-radius:2px;' />" . $row['operator'];
                        ?>
                    </td>
                    <td style="width: 30%;">
                        <?php echo $row['reason'];?>
                    </td>
                    <td>
                        <?php
                        echo $timeResult;
                        ?>
                    </td>
                    <td>
                        <?php

                        if($row['end'] == -1) {
                            echo 'Permanent Mute';
                        } else {
                            echo $expiresResult;
                        }

                        ?>
                    </td>
                </tr>
                <?php
            }
            $conn->close();
            ?>
            </tbody>
            </table>
         </div>
      </div>
       <?php include 'includes/footer.php'; ?>
   </div>