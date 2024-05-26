<?php
  require("Ansi.php");
  $color_tag = "";
  if (isset($_GET['color'])) {
    $COLORS = ["black", "red", "green", "yellow", "blue", "magenta", "cyan", "white", "gray"];
    $tmp = false;
    foreach($COLORS as $color) {
      if ($_GET['color'] == $color) {
        $tmp = true;
        break;
      }
    }
    if ($tmp == true) { 
      $color_tag = "<" . $_GET['color']. ">";
    } else {
      echo "color not found, please change the color via \"slowfetch set <color>\"" . "\r\n";
    }
  }

  $file = file('/etc/os-release');
  $os_info = $file[0];
  echo Ansi::tagsToColors($color_tag . "OS: " . substr($os_info, 13, strlen($os_info) -14 -1) . "\r\n");

  $file = file('/proc/cpuinfo');
  $proc_info = $file[4];
  $cpu_model = substr($proc_info, 13, strlen($proc_info) - 12);
  echo Ansi::tagsToColors($color_tag . "CPU: " . $cpu_model);

  $output = trim(shell_exec("glxinfo | egrep -i 'device'"), " ");
  $gpu_name = substr($output, 8, strlen($output) - 8 - 10);
  echo Ansi::tagsToColors($color_tag . "GPU: " . $gpu_name . "\r\n");

  $output =  str_replace(" ", "\n", ltrim(shell_exec("glxinfo | egrep -i 'memory'")));
  $gpu_vram = explode("\n", $output)[2];
  echo Ansi::tagsToColors($color_tag . "VRAM: " . $gpu_vram . "\r\n");

  $file = file('/proc/meminfo');
  $meminfo = $file[0];
  $mem_total_in_kb = substr($meminfo, 9, strlen($meminfo) - 9 - 3);
  $total_memory = ((int)$mem_total_in_kb / 1024) / 1024;
  echo Ansi::tagsToColors($color_tag . "RAM: " . substr((string)$total_memory, 0, 5) . " GiB" . "\r\n");