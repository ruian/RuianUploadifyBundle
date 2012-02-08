<?php
namespace Ruian\UploadifyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Ruian\UploadifyBundle\Model\Encrypt;

class ResourceType extends AbstractType
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getParent(array $options)
    {
        return 'file';
    }

    public function getDefaultOptions(array $options)
    {
        $session_id = session_id();

        if (false === array_key_exists('folder', $options['data'])) {
            throw new \Exception('You must provide a "folder" to save your data', 1);
        }

        if (false === array_key_exists('path', $options['data'])) {
            throw new \Exception('You must provide a "path" to save your data', 1);
        }

        if (false === array_key_exists('copy', $options['data'])) {
            throw new \Exception('You must provide a "copy"', 1);
        }

        return array(
            'data_class' => 'Ruian\UploadifyBundle\Model\Resource',
            'attr'       => array(
                'data-session'  => urlencode($this->encrypt($session_id)),
                'data-folder'   => $options['data']['folder'],
                'data-preview'  => array_key_exists('preview', $options['data']) ? $options['data']['preview'] : null,
                'data-path'     => $options['data']['path'],
                'data-copy'     => $options['data']['copy'],
            ),
            'required' => false
        );
    }

    public function getName()
    {
        return 'uploadify';
    }

    protected function encrypt($string)
    {
        $crypt = new Encrypt($this->token);
        return $crypt->encrypt($string);
    }
}
