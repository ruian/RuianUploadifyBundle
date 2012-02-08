<?php
namespace Ruian\UploadifyBundle\Interfaces;

interface ResourceInterface
{
    public function getFile();
    public function setFile($value);

    public function getFolder();
    public function setFolder($value);

    public function toArray();

    public function upload();
}

