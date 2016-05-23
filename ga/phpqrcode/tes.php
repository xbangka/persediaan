<?php

   include('qrlib.php');

   $tempDir = 'barkcode/';   
   $codeContents = '56de8782b3552';
   $fileName     = $codeContents.'.png';

   $pngAbsoluteFilePath = $tempDir.$fileName;
   $urlRelativeFilePath = 'barkcode/' . $fileName;

   if (!file_exists($pngAbsoluteFilePath)) {
      QRcode::png($codeContents, $pngAbsoluteFilePath);
   }
   else {
      echo "Not working!";
   }

   echo '<img src="'.$urlRelativeFilePath.'" />';

?>