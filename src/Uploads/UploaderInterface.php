<?php


namespace App\Uploads;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface UploaderInterface
 * @package App\Uploads
 */
interface UploaderInterface
{
    /**
     * @param UploadedFile $file
     * @return string
     */
    public  function upload(UploadedFile $file ): string;

}

