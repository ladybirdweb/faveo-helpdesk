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
use Mremi\UrlShortener\Provider\Baidu\BaiduProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Expands the short given URL using the Google API.
 *
 * @author zacksleo <zacksleo@gmail.com>
 */
class BaiduExpandCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('baidu:expand')
            ->setDescription('Expands the short given URL using the dwz.cn API')
            ->addArgument('short-url', InputArgument::REQUIRED, 'The short URL to expand')
            ->addOption('options', null, InputOption::VALUE_REQUIRED, 'An array of options used by request');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $link = new Link();
        $link->setShortUrl($input->getArgument('short-url'));
        $options = $input->getOption('options') ? json_decode($input->getOption('options'), true) : [];

        $provider = new BaiduProvider($options);

        try {
            $provider->expand($link);

            $output->writeln(sprintf('<info>Success:</info> %s', $link->getLongUrl()));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>Failure:</error> %s', $e->getMessage()));
        }
    }
}
