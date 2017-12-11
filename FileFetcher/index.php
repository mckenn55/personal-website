<?php
if($_POST['file'] != null)
{
  if(strpos($_POST['file'],"http") !== false)
  {
    $_POST['file'] = str_replace(";","&#59;",$_POST['file']);
    $_POST['file'] = str_replace(" ","%20",$_POST['file']);

    $breakdown = explode(".",$_POST['file']);
    $extension = end($breakdown);
    $time = time();
    $filename = "/tmp/".$time . "." . $extension;
    $password = rand(99999,1000000);
    shell_exec("wget  -O ".$filename." ".escapeshellarg($_POST['file']));
    shell_exec("zip -P ".$password." -r ".$time.".zip ".$filename);
    ?>
    <a href="<?php echo $time;?>.zip"><?php echo $time?>.zip</a> <br /><br />
    The archive password is: <?php echo $password;?>
    <?php
  }
  else
  {
    echo "Invalid link given.";
  }
}
else
{
  ?>
  <form action="?" method="POST">
    <input type="text" name="file" /> <br />
    <input type="submit" value="submit" name="submit" />
  </form>
  <?php
}

 $files = glob("*");
  $time  = time();

  foreach($files as $file)
    if(is_file($file))
      if($time - filemtime($file) >= 60*60*24) // 2 days
        if($file != "index.php")
          unlink($file);

?>
