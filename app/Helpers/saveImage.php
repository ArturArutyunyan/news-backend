<?php

function saveImage($dir, $prop, $request, $element) {
    $destination_path = "public/images/" . $dir;
    $file = $request->file($prop);
    $prop_name = $file->getClientOriginalName();  
    $path = $request->file($prop)->storeAs($destination_path, $prop_name);
    $element->$prop = $prop_name;
}
