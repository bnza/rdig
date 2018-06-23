<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 23/06/18
 * Time: 8.40
 */

namespace App\Command\Csv;

use App\Service\Job\Csv\CsvImportFindingFromFileJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Command\AbstractJobCommand;
use App\Service\Job\JobManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CsvImportFindingsFromFileCommand extends AbstractJobCommand implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $dataEm;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var string
     */
    protected $dir;

    public function __construct(JobManager $manager, EntityManagerInterface $dataEm, ValidatorInterface $validator)
    {
        $this->manager = $manager;
        $this->dataEm = $dataEm;
        $this->validator = $validator;
        parent::__construct($manager);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rdig:job:csv:import:findings:from_file')
            ->setDescription('Import finding CSV file from file into DB, match campaign format')
            ->setHelp('Import finding CSV into DB guessing finding type using first infix field, match campaign format eg. TH13O.csv, TH13P.csv, TH13S.csv')
            ->addArgument('filename', InputArgument::REQUIRED, 'One of the three csv file for the given campaign');
    }

    protected function getFiles(InputInterface $input): array
    {
        $files = [];
        $types = ['O', 'P', 'S'];
        $filename = $input->getArgument('filename');
        $this->dir = dirname($filename);
        $basename = basename($filename);
        foreach ($types as $type)
        {
            $currBasename = substr_replace($basename, $type, 4, 1);
            if (file_exists($this->dir.DIRECTORY_SEPARATOR.$currBasename)) {
                $files[] = $currBasename;
            }

        }
        return $files;

    }

    public static function getSubscribedEvents()
    {
        return array_merge(
            [], parent::$events
        );
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $files = $this->getFiles($input);

        //$this->dataEm->beginTransaction();
        foreach ($files as $i => $file) {
            $this->output->writeln(sprintf('[%d] -> %s', $i, $file));
            $this->initJob(
                CsvImportFindingFromFileJob::class,
                [
                    $this->manager->getEntityManager(),
                    $this->dataEm,
                    $this->validator
                ]);
            $filename = "{$this->dir}/$file";
            $this->job->setFilePath($filename);
            try {
                $this->job->run();
                //$this->dataEm->commit();
            } catch (\Exception $e) {
                $output->writeln("");
                $output->writeln("<error>\n\n{$e->getMessage()}\n</error>");
                $output->writeln("<error>\n\n{$e->getFile()}:{$e->getLine()}\n</error>", OutputInterface::VERBOSITY_VERBOSE);
                //$this->dataEm->rollback();
            }
        }


    }
}