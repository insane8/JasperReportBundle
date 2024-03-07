<?php

namespace Mesd\Jasper\ReportBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MesdJasperReportExtension extends Extension
{
    public function load( array $configs, ContainerBuilder $container ) {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration( $configuration, $configs );

        $loader = new YamlFileLoader( $container, new FileLocator( __DIR__.'/../Resources/config' ) );
        $loader->load( 'services.yml' );

        //Setup the client service interface
        $reportClientDefinition = $container->getDefinition('mesd.jasper.report.client');

        //Set the connection settings from the config file
        $reportClientDefinition->addMethodCall('setReportUsername', array($config['connection']['username']));
        $reportClientDefinition->addMethodCall('setReportPassword', array($config['connection']['password']));
        $reportClientDefinition->addMethodCall('setReportHost', array($config['connection']['host']));
        $reportClientDefinition->addMethodCall('setReportPort', array($config['connection']['port']));
        $reportClientDefinition->addMethodCall('setVersion', array($config['version']));

        //Set the report cache settings
        $reportClientDefinition->addMethodCall('setReportCacheDir', array($config['report_cache']['cache_dir']));

        //Set the resource list cache settings
        $reportClientDefinition->addMethodCall('setUseFolderCache', array($config['folder_cache']['use_cache']));
        $reportClientDefinition->addMethodCall('setFolderCacheDir', array($config['folder_cache']['cache_dir']));
        $reportClientDefinition->addMethodCall('setFolderCacheTimeout', array($config['folder_cache']['cache_timeout']));

        //Set security settings
        $reportClientDefinition->addMethodCall('setUseSecurity', array($config['report_security']['use_security']));

        //Set the input control settings
        $reportClientDefinition->addMethodCall('setFormsHandlerServiceName', array($config['forms_handler']));
        $reportClientDefinition->addMethodCall('setOptionHandlerServiceName', array($config['options_handler']));
        $reportClientDefinition->addMethodCall('setDefaultInputOptionsSource', array($config['default_input_options_source']));

        //Set the default folder
        $reportClientDefinition->addMethodCall('setDefaultFolder', array($config['default_folder']));

        //Set the entity manager that will handle report history records
        $reportClientDefinition->addMethodCall('setEntityManager', array($config['report_history']['entity_manager']));

        //Connect to the server
        $reportClientDefinition->addMethodCall('init');

        //Setup the report loader service
        $reportLoaderDefinition = $container->getDefinition('mesd.jasper.report.loader');

        //Set the defaults
        $reportLoaderDefinition->addMethodCall('setReportCacheDir', array($config['report_cache']['cache_dir']));
        $reportLoaderDefinition->addMethodCall('setDefaultAttachAssetUrl', array($config['report_loader']['default_attach_asset_url']));
        $reportLoaderDefinition->addMethodCall('setDefaultAssetRoute', array($config['report_loader']['default_asset_route']));
        $reportLoaderDefinition->addMethodCall('setDefaultPage', array($config['report_loader']['default_page']));

        //Setup the display helper
        $displayHelperDefinition = $container->getDefinition('mesd.jasper.report.display_helper');

        //Set the defaults
        $displayHelperDefinition->addMethodCall('setDefaultExportRoute', array($config['display']['default_export_route']));

        //Setup the report history service
        $reportHistoryDefinition = $container->getDefinition('mesd.jasper.report.history');

        //Set the entity manager name to the same as the client
        $reportHistoryDefinition->addMethodCall('setEntityManager', array($config['report_history']['entity_manager']));

        //Get the security service definition
        $reportSecurityDefinition = $container->getDefinition('mesd.jasper.report.security');

        //Append the project root dir to the security file
        $securityFile = $container->getParameter('kernel.project_dir') . $config['report_security']['security_file'];

        //Setup the report security service
        $reportSecurityDefinition->addMethodCall('setSecurityFile', array($securityFile));
        $reportSecurityDefinition->addMethodCall('setDefaultRoles',  array($config['report_security']['default_roles']));
        $reportSecurityDefinition->addMethodCall('setMaxLevelSetAtDefault', array($config['report_security']['max_level_set_at_default']));
        $reportSecurityDefinition->addMethodCall('setDefaultFolder', array($config['default_folder']));
    }

    public function getConfiguration(array $config, ContainerBuilder $container) {
        //Create the configruation for the report bundle
        return new Configuration();
    }

    public function getAlias() {
        return 'mesd_jasper_report';
    }
}
