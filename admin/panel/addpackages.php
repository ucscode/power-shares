<?php

require __dir__ . '/sub-config.php';


if ($_SERVER['REQUEST_METHOD'] == "POST"){







$target_dir = "../../users/nn/pages/da/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$name = $_POST['name'];	
$amount = $_POST['amount'];	
$brate = $_POST['brate'];
$srate = $_POST['srate'];	
$worth = $_POST['worth'];
$validity = $_POST['validity'];
$dastatus = $_POST['dstatus'];
$category = $_POST['category'];	
$subcategory = $_POST['subcategory'];	
$sellerID = $_SESSION['username'];
$sstatus = $_POST['sstatus'];
$review = $_POST['review'];

// Check if image file is a actual image or fake image


if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $msg=  "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $msg=  "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $msg=  "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $msg=  "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $msg=  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   $msg=  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	 $fileToUpload = $_FILES["fileToUpload"]["name"];

	 $sql = "INSERT INTO assets(name,amount,daimage,brate,srate,worth,validity,dastatus,category,subcategory,sellerID,sstatus,review)
  VALUES ('$name','$amount','$fileToUpload','$brate','$srate','$worth','$validity','$dastatus','$category','$subcategory','$sellerID','$sstatus','$review')";

	  mysqli_query($link, $sql) or die(mysqli_error($link));

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $msg= "Your Asset has be stored.";
    } else {
        $msg= "Sorry, there was an error uploading your file.";
    }
}

}








include "header.php";


    ?>


<div class="col-md-12 col-sm-12 col-sx-12">
   <div class="box box-default">
      <div class="box-header with-border">
         <h4 align="center"><i class="fa fa-gears"></i>NEW SHARES </h4>
      </div>
      <div class='row'>
         <div class="col-md-12 col-sm-12 col-sx-12">
            <div class="box box-default">
               <div class="box-header with-border">
                  <h2 align="center" style="color:black">Shares Details</h2>
               </div>
               <div class=''>
                  <form action="addpackages.php" method="POST" enctype="multipart/form-data"  class="form-horizontal form-label-left" >
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Shares Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" name="name" id="fileToUpload" class="form-control col-md-7 col-xs-12" required >
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Shares Category <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <select  name="category" id="fileToUpload" class="form-control col-md-7 col-xs-12" required >
                              <?php
                                 $sql = "SELECT * FROM sharesgroup";
                                 $result = $link->query($sql);
                                 
                                 if ($result->num_rows > 0) {
                                 // output data of each row
                                 while($row = $result->fetch_assoc()) {?>
                              <option value="<?php echo $row["sharescat"];?>"><?php echo $row["sharescat"];?></option>
                              <?php  
                                 }
                                 } else {
                                 echo "No Shares Available In Store";
                                 }?>
                           </select>
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Shares Sub-Category <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <select  name="category" id="fileToUpload" class="form-control col-md-7 col-xs-12" required >
                              <?php
                                 $sql = "SELECT * FROM sharesgroup";
                                 $result = $link->query($sql);
                                 
                                 if ($result->num_rows > 0) {
                                 // output data of each row
                                 while($row = $result->fetch_assoc()) {?>
                              <option value="<?php echo $row["sharesubcat"];?>"><?php echo $row["sharesubcat"];?></option>
                              <?php  
                                 }
                                 } else {
                                 echo "No Shares Available In Store";
                                 }?>
                           </select>
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Amount <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" name="amount" id="fileToUpload" class="form-control col-md-7 col-xs-12" required >
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Buy Rate <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" name="brate" id="fileToUpload" class="form-control col-md-7 col-xs-12" required >
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sell Rate <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="text" name="srate" id="fileToUpload" class="form-control col-md-7 col-xs-12" required >
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Gift-Card image <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input type="file" name="fileToUpload" id="fileToUpload" class="form-control col-md-7 col-xs-12" required >
                        </div>
                     </div>
                     <div class="col-md-6 col-md-offset-3">
                        <button type="submit"  class="btn btn-primary" value="Upload Image" name="submit">Upload Gift card</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


