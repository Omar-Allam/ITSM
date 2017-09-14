<?php
/**
 * Created by PhpStorm.
 * User: hazem
 * Date: 13/9/17
 * Time: 3:48 PM
 */

namespace App\Reports;


use Illuminate\Support\Collection;
use App\Report;

abstract class ReportContract
{
    /** @var array */
    protected $report;

    /** @var array */
    protected $parameters;

    /** @var Collection */
    protected $data;

    /** @var int */
    protected $perPage = 50;

    public function __construct(Report $report)
    {
        $this->report = $report;

        // Make easy access to parameters
        $this->parameters = $report->parameters;
        $this->run();
    }

    abstract function run();

    abstract function html();

    abstract function excel();

    abstract function pdf();

    abstract function csv();
}