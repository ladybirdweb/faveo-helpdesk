<?php

/*
 * This file is part of the Mremi\UrlShortener library.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mremi\UrlShortener\Command;

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Sina\SinaProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Shortens the long given URL using the Google API.
 *
 * @author zacksleo <zacksleo@gmail.com>
 */
class SinaShortenCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('sina:shorten')
            ->setDescription('Shortens the long given URL using the Sina API')
            ->addArgument('long-url', InputArgument::REQUIRED, 'The long URL to shorten')
            ->addArgument('api-key', InputArgument::REQUIRED, 'A Sina API key, optional')
            ->addOption('options', null, InputOption::VALUE_REQUIRED, 'An array of options used by request');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $link = new Link();
        $link->setLongUrl($input->getArgument('long-url'));
        $options = $input->getOption('options') ? json_decode($input->getOption('options'), true) : [];

        $provider = new SinaProvider($input->getArgument('api-key'), $options);

        try {
            $provider->shorten($link);

            $output->writeln(sprintf('<info>Success:</info> %s', $link->getShortUrl()));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>Failure:</error> %s', $e->getMessage()));
        }
    }
}
