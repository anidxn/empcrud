<?php 
    session_start();

    $logged_user = "";
    $usrid = 0;

    if(!isset($_SESSION['login_user'])){
        header("location:index.php?err=2");
        die(); //get out
    } else {
        $logged_user = $_SESSION['login_user'];
        $usrid = $_SESSION["login_usrid"];  // String value
    }

   
?>

<!-- FIXED navigation bar irrespective of the page folder location -->
<nav>
    <a href='<?php echo '/empcrud/dashboard.php'; ?>'>Dashboard</a>
    <a href='<?php echo '/empcrud/usrgen.php'; ?>'>Create user</a>
    <a href='<?php echo '/empcrud/viewall.php'; ?>'>View all user</a>
    <a href='<?php echo '/empcrud/offices.php'; ?>'>Offices (dependency DDL)</a>
    <a href='<?php echo '/empcrud/autofillsrch.php'; ?>'>Projects (Autofill)</a>
    <a href='<?php echo '/empcrud/pg_login.php'; ?>'>Switch to postgres</a>
    <a href='<?php echo '/empcrud/pdo/data_store.php'; ?>'>PDO</a>
    <div class="dropdown">
      <button class="dropbtn">Uploads</button>
      <div class="dropdown-content">
        <a href='<?php echo '/empcrud/file_upload/upload.php'; ?>'>Upload to folder</a>
        <a href='<?php echo '/empcrud/file_upload/upload_B64.php'; ?>'>Upload to DB (Base64)</a>
        <a href='<?php echo '/empcrud/file_upload/upload_BLOB.php'; ?>'>Upload to DB (BLOB)</a>
        <a href='<?php echo '/empcrud/file_upload/upload_fileWithB64.php'; ?>'>Upload to DB (Base64) + Folder</a>
        <a href='<?php echo '/empcrud/file_upload/upload_multiple.php'; ?>'>Upload multiple files to Folder</a>
      </div>
    </div>
    <a href='<?php echo '/empcrud/logout.php'; ?>'>Logout</a>
  </nav>

  <br>
  Welcome <?php echo $logged_user; ?><br>