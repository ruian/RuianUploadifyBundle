<?php

namespace Ruian\UploadifyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ruian_uploadify');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->variableNode('token')->defaultValue('my_secret_token')->end()
                ->variableNode('auto')->defaultValue(true)->end()
                ->variableNode('buttonClass')->defaultValue('uploadify-button')->end()
                ->variableNode('buttonCursor')->defaultValue('hand')->end()
                ->variableNode('buttonImage')->defaultNull()->end()
                ->variableNode('buttonText')->defaultValue('SELECT FILES')->end()
                ->variableNode('checkExisting')->defaultFalse()->end()
                ->variableNode('debug')->defaultFalse()->end()
                ->variableNode('fileObjName')->defaultValue('Filedata')->end()
                ->variableNode('fileSizeLimit')->defaultValue(0)->end()
                ->variableNode('fileTypeDesc')->defaultValue('All Files')->end()
                ->variableNode('fileTypeExts')->defaultValue('*.*')->end()
                ->variableNode('formData')->defaultNull()->end()
                ->variableNode('height')->defaultValue(30)->end()
                ->variableNode('method')->defaultValue('post')->end()
                ->variableNode('multi')->defaultTrue()->end()
                ->variableNode('overrideEvents')->defaultNull()->end()
                ->variableNode('preventCaching')->defaultTrue()->end()
                ->variableNode('progressData')->defaultValue('percentage')->end()
                ->variableNode('queueID')->defaultFalse()->end()
                ->variableNode('queueSizeLimit')->defaultValue(999)->end()
                ->variableNode('removeCompleted')->defaultTrue()->end()
                ->variableNode('removeTimeout')->defaultValue(3)->end()
                ->variableNode('requeueErrors')->defaultFalse()->end()
                ->variableNode('successTimeout')->defaultValue(30)->end()
                
                ->variableNode('swf')->isRequired()->end()
                ->variableNode('uploader')->isRequired()->end()

                ->variableNode('uploadLimit')->defaultValue(999)->end()
                ->variableNode('width')->defaultValue(120)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
