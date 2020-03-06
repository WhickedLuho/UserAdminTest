<?php
function uploadFile($file, $destination, $settings) {
   $status_array = array(
      array(
         'status'    =>       '',
         'msg'       =>       ''),

      array(
         'name'      =>    '',
         'path'      =>    '',
         'extension' =>    '')   
      );

   $file_tmp   =  $_FILES['image']['tmp_name'];
  
    if(in_array($file[0]['extension'],$settings[0]['allowed_extension'])=== false){
      $status_array[0]['msg'] .="extension not allowed, please choose a JPEG or PNG file. ";
    }
    if($file[0]['size'] > $settings[0]['max_file_size']){
      $status_array[0]['msg'] .='File size must be excately 2 MB .';
    }
   if(empty($status_array[0]['msg'])==true){
      if (!file_exists($destination)) {
         mkdir($destination, 0777, true);
      }
         $file_NameClean = checkExists($destination, $file);
         move_uploaded_file($file_tmp,$destination.$file_NameClean);

         $status_array[1]['name']      =     $file_NameClean;
         $status_array[1]['path']      =     $destination .'';
         $status_array[1]['extension'] =     $file[0]['extension'];
         $status_array[0]['status']    =     'Succes';
         $status_array[0]['msg']       =     'The file was uploaded succesfully :' .$destination;

      }else{
         $status_array[0]['status']    .=     'Error';
         $status_array[0]['msg']       .=     'The file was not uploaded :' .$destination;
      }

      //var_dump($status_array);
      return $status_array;
      }
      //uploadFile($file, $file_desti, $settings);
      
//-File exist checking
   function checkExists($dest, $file, $count = 0) {
       $tmp = explode('.', $file[0]['name'])[0];
       $filename = $tmp.($count == 0 ? '' : '_'.$count).'.'.$file[0]['extension'];
      if($count == 0 && file_exists($dest. $filename)) {
         return checkExists($dest, $file, ++$count);
      } else if(file_exists($dest. $filename)) {
         return checkExists($dest, $file, ++$count);
      } else{
         return $filename;
         }
      }