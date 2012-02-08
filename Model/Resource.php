<?php
namespace Ruian\UploadifyBundle\Model;

use Ruian\UploadifyBundle\Interfaces\ResourceInterface;
use Symfony\Component\HttpFoundation\File\File;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
/**
* 
*/
class Resource implements ResourceInterface
{   
    protected $file;

    protected $folder;

    function __construct()
    {
        
    }

    public function getWeb()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web';
    }

    /**
     * @param string file
     * @return void
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
    
    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string folder
     * @return void
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }
    
    /**
     * @return string
     */
    public function getFolder()
    {
        if (null === $this->folder) {
            throw new Exception("folder is required for your ressource", 1);
        }

        return $this->folder;
    }

    /**
     * @return void
     */
    public function upload()
    {
        if ($this->file instanceof File) {
            $name = sha1($this->file->getClientOriginalName() . uniqid() . getrandmax()) . '.' . $this->file->guessExtension();
            $this->file->move($this->getWeb() . $this->folder, $name);
            $this->file = $name;
        } else {
            throw new FileException("It must be a Symfony\Component\HttpFoundation\File\File instance");
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'folder' => $this->folder,
            'file'   => $this->file,
        );
    }
}
