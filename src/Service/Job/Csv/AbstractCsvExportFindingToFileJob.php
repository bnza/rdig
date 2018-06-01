<?php

namespace App\Service\Job\Csv;

use App\Repository\AbstractDataRepository;
use App\Service\Job\Csv\Task\CsvFilterCountRecordsTask;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractCsvExportFindingToFileJob extends AbstractCsvJob
{
    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var array
     */
    protected $filter;

    /**
     * @var array
     */
    protected $sort;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    protected $csvExportPath;

    abstract protected function getHeader(): array;

    abstract public function getFields(): array;

    public function getStepsNum(): int
    {
        return $this->job->getRecordCount();
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        $entityName = ucfirst($this->entityName);

        return "\\App\\Entity\\Main\\$entityName";
    }

    /**
     * @return string
     */
    protected function getCsvExportToFileTaskClass(): string
    {
        $entityName = ucfirst($this->entityName);

        return "\\App\\Service\\Job\\Csv\\Task\\CsvExport${entityName}ToFileTask";
    }

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EntityManagerInterface $em,
        EntityManagerInterface $dataEm,
        $entityName,
        $filter,
        $sort,
        $hash = '')
    {
        parent::__construct($dispatcher, $em, $dataEm, $hash);
        if (!is_array($filter)) {
            $f = json_decode($filter, true);
            $filter = $f ? $f : [];
        }
        $this->filter = $filter;
        if (!is_array($sort)) {
            $s = json_decode($sort, true);
            $sort = $s ? $s : [];
        }
        $this->sort = $sort;
        $this->entityName = $entityName;
    }

    public function getCsvOutputPath(): string
    {
        if (!$this->csvExportPath) {
            $this->csvExportPath = sys_get_temp_dir() . '/export_' . $this->getHash() . '.csv';
        }
        return $this->csvExportPath;
    }

    public function getRepository(): AbstractDataRepository
    {
        return $this->dataEm->getRepository($this->getEntityClassName());
    }

    public function setFilePath(string $path)
    {
        $this->path = $path;
    }

    public function getTaskList(): array
    {
        return [
            [
                CsvFilterCountRecordsTask::class,
                [
                    $this->dataEm,
                    $this->filter,
                    []
                ],
            ],
            [
                Task\CsvWriterCreateFromPath::class,
                [
                    $this->getCsvOutputPath(),
                    $this->getHeader()
                ],
            ],
            [
                $this->getCsvExportToFileTaskClass(),
                [
                    $this->dataEm,
                    $this->filter,
                    $this->sort,
                ],
            ],
        ];
    }

    public function getCsvExportPath()
    {
        if (!$this->csvExportPath) {
            $this->csvExportPath = sys_get_temp_dir().'/export_'.$this->getHash().'.csv';
        }

        return $this->csvExportPath;
    }
}
