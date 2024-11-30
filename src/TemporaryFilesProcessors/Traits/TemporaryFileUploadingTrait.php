<?php

namespace TemporaryFilesHandlers\TemporaryFilesProcessors\Traits;

use TemporaryFilesHandlers\TemporaryFilesHandler;
use CustomFileSystem\CustomFileUploader;
use CustomFileSystem\S3CustomFileSystem\CustomFileUploader\S3CustomFileUploader;
use Exception;

trait TemporaryFileUploadingTrait
{
    protected ?CustomFileUploader $fileUploader = null;

    /**
     * @return TemporaryFilesHandler
     */
    protected function initFileUploader() : TemporaryFilesHandler
    {
        if($this->fileUploader){return $this;}
        $this->fileUploader = new S3CustomFileUploader();
        return $this;
    }

    /**
     * @param string $filePathToUpload
     * @param string $fileName
     * @param string $fileFolderRelevantPath
     * @throws Exception
     * @return string
     * Returns Uploaded File's Relevant path in Storage (storage relevant path = need to concatenate it with storage main path  )
     */
    public function uploadToStorage(string $filePathToUpload , string $fileName = "" ) : string
    {
        if(!$fileName)
        {
            $fileName = $this->getFileDefaultName($filePathToUpload);
        }

        $fileNewRelevantPath = $this->getTempFileRelevantPath($fileName); 
 
        $this->initFileUploader();
        $file = $this->fileUploader->getUploadedFile($filePathToUpload , $fileNewRelevantPath);
        $this->fileUploader->makeFileReadyToStore($fileNewRelevantPath , $file);
        $this->fileUploader->uploadFiles();

        //If No Exception Is Thrown .... Now We Can Delete The Temporary Folder
        $this->deleteTempFolder();
        return $fileNewRelevantPath;
    }

}
