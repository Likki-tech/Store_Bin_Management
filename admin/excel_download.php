<?php
  require_once('connect.php');
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=Fabric_Details.xls" );
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
  header("Pragma: public");
	  
	 ?>

<table>
  <thead>
    <tr>
        <th>Date</th>
        <th>Material Type</th>
        <th>Material Code</th>
        <th>Rack Number</th>
        <th>Bin Number</th>
        <th>No. of Rolls</th>
        <th>Roll Number</th>
        <th>Quantity</th>
        <th>Width</th>
        <th>Shade</th>                    
        <th>Actual Quantity</th>
        <th>PO Quantity</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $qryreport = mysqli_query($conn,"SELECT * FROM fabric") or die(mysqli_error());
	
    $sqlrows=mysqli_num_rows($qryreport);
    WHILE ($reportdisp=mysqli_fetch_array($qryreport)) {
    ?>
    <tr>
      <td><?php echo $reportdisp['DATE'] ?></td>
      <td><?php echo $reportdisp['MATERIAL_TYPE'] ?></td>
      <td><?php echo $reportdisp['MATERIAL_CODE'] ?></td>
      <td><?php echo $reportdisp['RACK_NUM'] ?></td>
      <td><?php echo $reportdisp['BIN_NUM'] ?></td>
      <td><?php echo $reportdisp['NO_OF_ROLLS'] ?></td>
      <td><?php echo $reportdisp['ROLL_NUM'] ?></td>
      <td><?php echo $reportdisp['QTY'] ?></td>
      <td><?php echo $reportdisp['WIDTH_DETAILS'] ?></td>
      <td><?php echo $reportdisp['SHADE'] ?></td>
      <td><?php echo $reportdisp['actual_quantity'] ?></td>
      <td><?php echo $reportdisp['PO_QTY'] ?></td>
    <?php } ?>
  </tbody>
</table>