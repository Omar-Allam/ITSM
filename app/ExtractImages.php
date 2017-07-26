<?php
/**
 * Created by PhpStorm.
 * User: ceh007
 * Date: 7/25/17
 * Time: 4:14 PM
 */

namespace App;


class ExtractImages
{

    private $content;
    function __construct($content)
    {
        $this->content = $content;
    }

    public function extract()
    {
        $images_exist = preg_match_all('/<img src="data:image([\w\W]+?)\/>/', $this->content, $images, PREG_SET_ORDER);
        if ($images_exist) {
            foreach ($images as $image) {
                $data = explode(',', str_replace('/>', '', $image[0]));
                $extension = explode('/', explode(';', explode(';', $image[0])[0])[0]);
                $final_image = base64_decode($data[1] ?? $data[0]);
                $folder = storage_path('app/public/images/');
                if (!is_dir($folder)) {
                    mkdir($folder, 0775, true);
                }
                $filename = uniqid() . '.' . $extension[1];
                $path = url('/storage/images/' . $filename);
                file_put_contents($folder . $filename, $final_image);
                $this->content = str_replace($image[0], "<img src=\"$path\">", $this->content);
            }
        }
        return $this->content;
    }
}