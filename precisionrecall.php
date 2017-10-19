<meta charset="UTF-8">
<?php
/*
 * Autor: Laura
 */
 $dir    = __DIR__.'/Esta';
 $dirsave = __DIR__.'/Esta2';
 $var = scandir($dir);

 $counter = 0;

 foreach($var as $filename){
   if (($filename == '.' ) || ($filename == '..'))
      continue;
   $file = $dir.'/'.$filename;
   echo "Abrindo arquivo $filename \n";

   $corpus_handle = fopen($file, 'r');
   $corpus_array = [];

   $q = 0;
   while (($line = fgets($corpus_handle)) !== false){
     $word = trim($line);
     $term_doc = strtolower($word);
     $q++;
     $corpus_array[$term_doc] = $counter;

   }


   $dir_little_docs    = __DIR__.'/Esta3';
   $dir_to_save        = __DIR__.'/Esta2';
   $files_little_doc   = scandir($dir_little_docs);



   foreach($files_little_doc as $little_doc_filename){
     if (($little_doc_filename == '.' ) || ($little_doc_filename == '..'))
        continue;
     $counter++;

     $result_handle = fopen($dir_to_save .'/' . $little_doc_filename, 'a');

     if ($filename == $little_doc_filename){

     echo "Abrindo arquivo $little_doc_filename \n";

     $little_doc = file_get_contents($dir_little_docs . '/'. $little_doc_filename);
     $little_doc_array = explode("\n", $little_doc);
     $little_doc_array = array_filter($little_doc_array);
     $r = count($little_doc_array);


     $little_doc_optimize = [];
     $inter = 0;


     foreach ($little_doc_array as $line_on_little_doc) {
        $line_on_little_doc = trim($line_on_little_doc);
        if ($line_on_little_doc == '')
          continue;

       $word_on_little = strtolower($line_on_little_doc);

       if (isset($corpus_array[$word_on_little]) && ($corpus_array[$word_on_little] != $counter) ){
             $corpus_array[$word_on_little] = $counter;
           $inter++;
        }

   }

    $precision = ($inter/$r);
    $recall = ($inter/$q);
    fwrite($result_handle, $precision."\n");


  }else {
    continue;
  }

 }


}
    fclose($result_handle);
