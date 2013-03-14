<?php

function emptyDir($dir, $deleteMe = false) {
   if (!$dh = @opendir($dir)) {
      return;
   } else {
      while (false !== ($obj = readdir($dh))) {
         if ($obj == '.' || $obj == '..' || $obj == 'README') {
            continue;
         }
         if (!unlink($dir . '/' . $obj)) {
            $this->emptyDir($dir . '/' . $obj, true);
         }
      }
      closedir($dh);
      if ($deleteMe) {
         rmdir($dir);
      }
   }
}