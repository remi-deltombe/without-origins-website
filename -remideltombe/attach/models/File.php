<?php namespace  RemiDeltombe\Attach\Models;

use System\Models\File as FileBase;
use October\Rain\Database\Attach\Resizer;

class File extends FileBase
{
    /**
     * Saves a file
     * @param string $sourcePath An absolute local path to a file name to read from.
     * @param string $destinationFileName A storage file name to save to.
     */
    protected function putFile($sourcePath, $destinationFileName = null)
    {
        $result = parent::putFile($sourcePath, $destinationFileName);

        if($result && $this->isImage())
        {
            $rootPath = $this->getLocalRootPath();
            $filePath = $rootPath.'/'.$this->getDiskPath();

            $width = $this->getWidthAttribute();
            $height = $this->getHeightAttribute();

            if($width > 1900)
            {
                $height = 1900 * ($height/$width);
                $width = 1900;  
            }
            if($height > 1900)
            {
                $width = 1900 * ($width/$height);
                $height = 1900;
            }
            Resizer::open($filePath)
                ->resize(round($width), round($height), [])
                ->save($filePath);
        }

        return $result;
    }

}
