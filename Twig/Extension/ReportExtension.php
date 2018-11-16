<?php

namespace Mesd\Jasper\ReportBundle\Twig\Extension;

use Mesd\Jasper\ReportBundle\Helper\DisplayHelper;

class ReportExtension extends \Twig_Extension
{
    /**
     * The Jasper Reports Bundle display helper
     * @var DisplayHelper
     */
    private $displayHelper;

    /**
     * The default route to handle html page loads
     * @var string
     */
    private $defaultPageRoute;

    /**
     * Constructor
     *
     * @param DisplayHelper $displayHelper The display helper reference
     */
    public function __construct(DisplayHelper $displayHelper) {
        //Set stuff
        $this->displayHelper = $displayHelper;
    }

    //Get functions lists the functions in this class
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('mesd_report_render_page_links', [$this, 'renderPageLinks'],  array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('mesd_report_render_output', [$this, 'renderReportOutput'],  array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('mesd_report_render_export_links', [$this, 'renderExportLinks'],  array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders links for the html pages of a report
     *
     * @param  JasperClient\Client\Report $report The report object
     * @param  string                     $route  Symfony route for the action that handles html report page loads, optional,
     *                                              will default to the route set in the config if not set
     *
     * @return string                             The rendered output
     */
    public function renderPageLinks($report, $route = null) {
        return $this->displayHelper->renderPageLinks($report, $route ?: $this->defaultPageRoute);
    }

    /**
     * Renders the output of a report
     *
     * @param  JasperClient\Client\Report $report The report to render
     *
     * @return string                             The rendered output
     */
    public function renderReportOutput($report) {
        return $this->displayHelper->renderReportOutput($report);
    }

    /**
     * Renders export links for a cached report
     *
     * @param  JasperClient\Client\Report $report      The report object to export
     * @param  string                     $exportRoute Optional override to the default export route
     *
     * @return string                                  Rendered output
     */
    public function renderExportLinks($report, $exportRoute = null) {
        return $this->displayHelper->renderExportLinks($report, $exportRoute);
    }
}