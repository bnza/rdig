<?php

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

class CsvImportFindingFromDirCommand extends AbstractJobCommand implements EventSubscriberInterface
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

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rdig:job:csv:import:from_dir')
            ->setDescription('Import finding CSV file from directory into DB')
            ->setHelp('Import finding CSV into DB guessing finding type using first infix field')
            ->addArgument('dirname', InputArgument::REQUIRED, 'The CSV directory');
    }

    public function __construct(JobManager $manager, EntityManagerInterface $dataEm, ValidatorInterface $validator)
    {
        $this->manager = $manager;
        $this->dataEm = $dataEm;
        $this->validator = $validator;
        parent::__construct($manager);
    }

    public static function getSubscribedEvents()
    {
        return array_merge(
            [], parent::$events
        );
    }

    protected function getFiles(InputInterface $input): array
    {
        $files = [];
        $this->dir = $input->getArgument('dirname');
        foreach (new \DirectoryIterator($this->dir) as $fileInfo) {
            $filename = $fileInfo->getFilename();
            if (preg_match('/^[[:upper:]]{2}\d{2}[O|P|S].csv$/', $filename))
            {
                $files[] = $filename;
            }
        }
        return $files;

    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $files = $this->getFiles($input);
        $this->output->writeln(sprintf('%d files found in dir "%s"', count($files), $this->dir));

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
            } catch (\Exception $e) {
                $output->writeln("");
                $output->writeln("<error>\n\n{$e->getMessage()}\n</error>");
                $output->writeln("<error>\n\n{$e->getFile()}:{$e->getLine()}\n</error>", OutputInterface::VERBOSITY_VERBOSE);
            }
        }


    }
}