<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Command;

use Raptor\PHPMigrationHelper\ConfigLoader\ConfigLoader;
use Raptor\PHPMigrationHelper\ConfigLoader\ConfigLoaderInterface;
use Raptor\PHPMigrationHelper\Processor\DirectoryProcessor;
use Raptor\PHPMigrationHelper\Processor\DirectoryProcessorInterface;
use Raptor\PHPMigrationHelper\Processor\FileProcessor;
use Raptor\TestUtils\DataLoader\ProcessingDataLoader;
use Raptor\TestUtils\DataLoader\RecursiveDirectoryDataLoader;
use Raptor\TestUtils\DataProcessor\GeneratorDataProcessor;
use Raptor\TestUtils\DataProcessor\TypeFactory\GetTypeTypeFactory;
use Raptor\TestUtils\Generator\GeneratorInterface;
use Raptor\TestUtils\Generator\TestDataContainerGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command, that generates report that contains list of possible problems when migrations from PHP 7.1 to further
 * version.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class PHPMigrationHelperCommand extends Command
{
    /** @var int OK exit code when everything is OK */
    public const OK = 0;

    /** @var string $filePath */
    private $filePath;

    /** @var DirectoryProcessorInterface $processor */
    private $processor;

    /** @var ConfigLoaderInterface $configLoader */
    private $configLoader;

    /**
     * @param string $filePath path to file that should be generated
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->processor = new DirectoryProcessor(new FileProcessor());
        $this->configLoader = new ConfigLoader();
        parent::__construct();
    }

    /** @noinspection PhpMissingParentCallCommonInspection __approved__ parent method is overridden */
    /** @noinspection PhpUnused __approved__ used in generate-ide-test-containers */
    protected function configure(): void
    {
        $this->setName('report')
             ->setDescription('Generates compatibility report for PHP migration to further version')
             ->addArgument('from', InputArgument::REQUIRED, 'Enter version to migrate from:')
             ->addArgument('to', InputArgument::REQUIRED, 'Enter version to migrate to:')
             ->addArgument('report', InputArgument::REQUIRED, 'Enter filename fore report:');
    }

    /** @noinspection PhpMissingParentCallCommonInspection __approved__ parent method is overridden */
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int 0 if everything went fine, or an error code
     *
     * @noinspection PhpUnused __approved__ used in generate-ide-test-containers
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $versionFrom = $input->getArgument('from');
        $versionTo = $input->getArgument('to');
        $reportFile = $input->getArgument('report');
        $rules = $this->configLoader->load($versionFrom, $versionTo);
        $report = $this->processor->process($this->filePath, $rules);
        file_put_contents($reportFile, implode("\n", $report));

        return self::OK;
    }
}
