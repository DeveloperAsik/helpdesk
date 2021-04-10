<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Oreno_auth
 *
 * @author arief.firmansyah
 */
class Oreno_image_upload {

    //sample options array default value        
    //$options = array(
    //'id' => '',
    //'img_path' => '',
    //'img_size_width' => array('128', '320', '800', '1024'),
    //'img_name' => array('tiny', 'small', 'medium', 'large', 'original')
    //);

    public function do_upload($data = array(), $options = array()) {
        extract($options);
        $MAX_SIZE = 4000;

        $image = $data["name"];
        if (isset($options['origin_name']) && !empty($options['origin_name'])) {
            $image = $options["origin_name"];
        }
        $uploadedfile = $data['tmp_name'];


        $first3digit = '';
        if ($id) {
            if ($id < 100) {
                $first3digit = str_pad($id, 3, '0', STR_PAD_LEFT);
            } else {
                $first3digit = substr($id, 0, 3);
            }
        } else {
            $first3digit = '001';
        }

        //create default directory form default path and first 3 digit
        if (!is_dir($img_path . DIRECTORY_SEPARATOR . $first3digit)) {
            mkdir($img_path . DIRECTORY_SEPARATOR . $first3digit);
        }

        if (!is_dir($img_path . DIRECTORY_SEPARATOR . $first3digit . DIRECTORY_SEPARATOR . $id)) {
            mkdir($img_path . DIRECTORY_SEPARATOR . $first3digit . DIRECTORY_SEPARATOR . $id);
        }

        //create directory from image directory name
        if (isset($options['img_name']) && !empty($options['img_name'])) {
            foreach ($options['img_name'] AS $dir_name) {
                if (!is_dir($img_path . DIRECTORY_SEPARATOR . $first3digit . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $dir_name)) {
                    mkdir($img_path . DIRECTORY_SEPARATOR . $first3digit . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $dir_name);
                }
            }
        }
        if (!is_dir($img_path . DIRECTORY_SEPARATOR . $first3digit . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'original')) {
            mkdir($img_path . DIRECTORY_SEPARATOR . $first3digit . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'original');
        }

        //checking image extension
        if ($image) {
            $filename = stripslashes($image);
            $extension = strtolower($this->get_extension($filename));
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                echo ' Unknown Image extension ';
                $errors = 1;
            } else {
                //get file size form image
                $size = filesize($uploadedfile);
                if ($size > $MAX_SIZE * 1024) {
                    echo "You have exceeded the size limit... resize from original size";
                    $errors = 1;
                }
                //create new image from upload file
                if ($extension == "jpg" || $extension == "jpeg") {
                    $src = imagecreatefromjpeg($uploadedfile);
                } else if ($extension == "png") {
                    $src = imagecreatefrompng($uploadedfile);
                } else {
                    $src = imagecreatefromgif($uploadedfile);
                }
                //get image width and height from upload file
                list($width, $height) = getimagesize($uploadedfile);


                //original
                $newwidth0 = $width;
                $newheight0 = ($height / $width) * $newwidth0;
                $tmp0 = imagecreatetruecolor($newwidth0, $newheight0);
                imagecopyresampled($tmp0, $src, 0, 0, 0, 0, $newwidth0, $newheight0, $width, $height);
                $filename0 = $img_path . DIRECTORY_SEPARATOR . $first3digit . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'original' . DIRECTORY_SEPARATOR . $image;
                imagejpeg($tmp0, $filename0, 100);
                $link_ori[] = array('original' => "{$first3digit}/{$id}/original/{$image}");
                //other size from options
                if (isset($img_size_width) && !empty($img_size_width)) {
                    for ($i = 0, $no = 1; $i < count($img_size_width); $i++, $no++) {
                        ${"newwidth$no"} = $img_size_width[$i];
                        ${"newheight$no"} = ($height / $width) * ${"newwidth$no"};
                        ${"tmp$no"} = imagecreatetruecolor(${"newwidth$no"}, ${"newheight$no"});
                        imagecopyresampled(${"tmp$no"}, $src, 0, 0, 0, 0, ${"newwidth$no"}, ${"newheight$no"}, $width, $height);
                        ${"filename$no"} = $img_path . DIRECTORY_SEPARATOR . $first3digit . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $img_name[$i] . DIRECTORY_SEPARATOR . $image;
                        imagejpeg(${"tmp$no"}, ${"filename$no"}, 100);
                        $link[] = array($img_name[$i] => "{$first3digit}/{$id}/{$img_name[$i]}/{$image}");
                    }
                }

                imagedestroy($src);
                imagedestroy($tmp0);
                if (isset($img_size_width) && !empty($img_size_width)) {
                    for ($j = 1; $j < count($img_size_width); $j++) {
                        imagedestroy(${"tmp$j"});
                    }
                }

                $new_array = array_merge($link_ori, $link);
                $new_array_fr_key = array();
                $no = 0;
                foreach ($new_array AS $img) {
                    $key = array_keys($img);
                    $array_key_name = '';
                    for ($jk = 0; $jk < count($key); $jk++) {
                        $array_val = $img[$key[$jk]];
                        $array_key_name = $key[$jk];
                    }
                    $new_array_fr_key[$array_key_name] = $array_val;
                    $no++;
                }
                return $new_array_fr_key;
            }
        }
    }

    public function do_upload_ticket_files($data = array(), $options = array()) {
        extract($options);
        $MAX_SIZE = 4000;
        $image = $options["origin_name"];
        $uploadedfile = $data['tmp_name'];
        $code = $options['code'];
        //create default directory form default path and first 3 digit
        if (!is_dir($img_path)) {
            mkdir($img_path);
        }
        if (!is_dir($img_path . DIRECTORY_SEPARATOR . $code)) {
            mkdir($img_path . DIRECTORY_SEPARATOR . $code);
        }
        //checking image extension
        if ($image) {
            $filename = stripslashes($image);
            $extension = strtolower($this->get_extension($filename));
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
                echo ' Unknown Image extension ';
                $errors = 1;
            } else {
                //get file size form image
                $size = filesize($uploadedfile);
                if ($size > $MAX_SIZE * 1024) {
                    echo "You have exceeded the size limit... resize from original size";
                    $errors = 1;
                }
                //create new image from upload file
                if ($extension == "jpg" || $extension == "jpeg") {
                    $src = imagecreatefromjpeg($uploadedfile);
                } else if ($extension == "png") {
                    $src = imagecreatefrompng($uploadedfile);
                } else {
                    $src = imagecreatefromgif($uploadedfile);
                }
                //get image width and height from upload file
                list($width, $height) = getimagesize($uploadedfile);

                //original
                $newwidth0 = $width;
                $newheight0 = ($height / $width) * $newwidth0;
                $tmp0 = imagecreatetruecolor($newwidth0, $newheight0);
                imagecopyresampled($tmp0, $src, 0, 0, 0, 0, $newwidth0, $newheight0, $width, $height);
                $filename0 = $img_path . DIRECTORY_SEPARATOR . $code . DIRECTORY_SEPARATOR . $image;
                imagejpeg($tmp0, $filename0, 100);
                $link_ori[] = array('original' => "{$code}/{$image}");
                //other size from options
                if (isset($img_size_width) && !empty($img_size_width)) {
                    for ($i = 0, $no = 1; $i < count($img_size_width); $i++, $no++) {
                        ${"newwidth$no"} = $img_size_width[$i];
                        ${"newheight$no"} = ($height / $width) * ${"newwidth$no"};
                        ${"tmp$no"} = imagecreatetruecolor(${"newwidth$no"}, ${"newheight$no"});
                        imagecopyresampled(${"tmp$no"}, $src, 0, 0, 0, 0, ${"newwidth$no"}, ${"newheight$no"}, $width, $height);
                        ${"filename$no"} = $img_path . DIRECTORY_SEPARATOR . $code . DIRECTORY_SEPARATOR . $image;
                        imagejpeg(${"tmp$no"}, ${"filename$no"}, 100);
                        $link[] = array($img_name[$i] => "{$code}/{$image}");
                    }
                }

                imagedestroy($src);
                imagedestroy($tmp0);
                if (isset($img_size_width) && !empty($img_size_width)) {
                    for ($j = 1; $j < count($img_size_width); $j++) {
                        imagedestroy(${"tmp$j"});
                    }
                }

                $new_array = array_merge($link_ori, $link);
                $new_array_fr_key = array();
                $no = 0;
                foreach ($new_array AS $img) {
                    $key = array_keys($img);
                    $array_key_name = '';
                    for ($jk = 0; $jk < count($key); $jk++) {
                        $array_val = $img[$key[$jk]];
                        $array_key_name = $key[$jk];
                    }
                    $new_array_fr_key[$array_key_name] = $array_val;
                    $no++;
                }
                return $new_array_fr_key;
            }
        }
    }

    protected function get_extension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

}
