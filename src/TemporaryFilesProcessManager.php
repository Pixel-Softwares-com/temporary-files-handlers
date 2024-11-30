<?php

namespace TemporaryFilesHandlers;

use TemporaryFilesHandlers\TemporaryFilesCompressors\TemporaryFilesCompressor;
use TemporaryFilesHandlers\TemporaryFilesProcessors\TemporaryFilesProcessor;

abstract class TemporaryFilesProcessManager
{

    protected ?TemporaryFilesCompressor $filesCompressor = null;
    protected ?TemporaryFilesProcessor $filesProcessor = null;

 
    public function __construct(TemporaryFilesProcessor $filesProcessor)
    {
        //Setting Required Dependencies
        $this->setTemporaryFilesProcessor($filesProcessor);
    }

    /**
     * @return $this
     */
    public function setTemporaryFilesProcessor(TemporaryFilesProcessor $filesProcessor): self
    {
        $this->filesProcessor = $filesProcessor;
        return $this;
    }

    
    protected function setTemporaryFilesCompressor(TemporaryFilesCompressor $filesProcessor) : self
    {
        $this->filesCompressor =  $filesProcessor;
        return $this;
    }

    /**
     * @param string $DataFilePath
     * @return string|bool
     */
    abstract public function handleFileOperations(string $DataFilePath) : string | bool;
}
