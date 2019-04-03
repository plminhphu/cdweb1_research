<?php
function GetDirectorySize($path){
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}
function ViewByte($value)
{
	if($value<1024){
		return round($value, 2). ' bytes<br>';
	}else if($value>1024 && $value<1024*1024){
		return round($value/1024, 2). ' Kilobyte (KB)<br>';
	}else if($value>1024*1024 && $value<1024*1024*1024){
		return round($value/1024/1024, 2). ' Megabyte (MB)<br>';
	}else if($value>1024*1024*1024 && $value<1024*1024*1024*1024){
		return round($value/1024/1024/1024, 2) . ' Gigabyte (GB)<br>';
	}else if($value>1024*1024*1024*1024){
		return round($value/1024/1024/1024/1024, 2) . ' Terabyte (TB)<br>';
	}
}

