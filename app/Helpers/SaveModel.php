<?php
namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;

trait SaveModel
{
    /**
     * @param array $data
     */
    public function store(array $data)
    {
        if(isset($data['profile_image']))
            $data['profile_image'] = $this->resizeImage($data['profile_image']);

        foreach($data as $key => $value) {
            $this->$key = $value;
        }

        $this->save();
    }

    private function resizeImage($image)
    {
        $imageName = $image->getClientOriginalName();
        $imageName = "image/$imageName";
        Image::make($image->getRealPath())->resize(60, 40)->save(public_path($imageName));

        return $imageName;
    }
}
