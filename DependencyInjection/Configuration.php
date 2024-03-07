<?php

namespace Mesd\Jasper\ReportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('mesd_jasper_report');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('default_folder')->defaultValue('/reports')->end()
                ->scalarNode('version')->defaultValue('5.5.0')->end()
                ->arrayNode('connection')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('username')->defaultValue('please_change')->end()
                        ->scalarNode('password')->defaultValue('please_change')->end()
                        ->scalarNode('host')->defaultValue('please_change')->end()
                        ->scalarNode('port')->defaultValue('8080')->end()
                    ->end()
                ->end()
                ->arrayNode('folder_cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('use_cache')->defaultTrue()->end()
                        ->scalarNode('cache_dir')->defaultValue('../app/cache/jasper_resource_list/')->end()
                        ->scalarNode('cache_timeout')->defaultValue(30)->end()
                    ->end()
                ->end()
                ->arrayNode('report_cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('use_cache')->defaultTrue()->end()
                        ->scalarNode('cache_dir')->defaultValue('../report-store/reports/')->end()
                    ->end()
                ->end()
                ->arrayNode('display')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default_export_route')->defaultValue('MesdJasperReportBundle_export_cached_report')->end()
                    ->end()
                ->end()
                ->arrayNode('report_loader')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default_page')->defaultValue(1)->end()
                        ->scalarNode('default_attach_asset_url')->defaultTrue()->end()
                        ->scalarNode('default_asset_route')->defaultValue('MesdJasperReportBundle_render_cached_asset')->end()
                    ->end()
                ->end()
                ->arrayNode('report_history')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('entity_manager')->defaultValue('default')->end()
                    ->end()
                ->end()
                ->scalarNode('options_handler')->defaultValue('mesd.jasper.report.default_options_handler')->end()
                ->scalarNode('forms_handler')->defaultValue('mesd.jasper.report.default_options_handler')->end()
                ->scalarNode('default_input_options_source')->defaultValue('Fallback')->end()
                ->arrayNode('report_security')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('use_security')->defaultTrue()->end()
                        ->scalarNode('max_level_set_at_default')->defaultTrue()->end()
                        ->scalarNode('security_file')->defaultValue('/config/report_security.yml')->end()
                        ->arrayNode('default_roles')
                            ->defaultValue(array('ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPERADMIN'))
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}