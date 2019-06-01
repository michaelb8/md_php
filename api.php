<?php
  $path = "site";
  $output = array ();

  function parseDir ($path)
  {
    $scan = scandir($path, $output);

    for ($i=2; $i < count ($scan); $i++) { 
      $ipath = $path."/".$scan[$i];

      $dummy = array ();
      $dummy["path"] = $ipath;

      if (is_dir($ipath))
      {
        $dummy["name"] = $scan[$i];
        $dummy["content"] = parseDir ($ipath, $output);
        $dummy["type"] = "folder";
        $dummy["ui_name"] = substr($scan[$i], 2);
      }
      if (is_file($ipath))
      {
        $dummy["file"] = $scan[$i];
        $dummy["type"] = "file";
        $dummy["ext"] = substr(strrchr($scan[$i],'.'),1);

        if ($dummy["ext"] == "md")
        {
          $dummy["md"] = file_get_contents ($dummy["path"]);
        }
      }
      $output[] = $dummy;
    }
    // var_dump ($output);
    return $output;
  }
  $output = parseDir ($path, $output);
  $myJSON = json_encode($output);

  echo $myJSON;
?>