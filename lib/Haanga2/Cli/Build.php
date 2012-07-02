<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2012 César Rodas and Meneame SL                                   |
  +---------------------------------------------------------------------------------+
  | Redistribution and use in source and binary forms, with or without              |
  | modification, are permitted provided that the following conditions are met:     |
  | 1. Redistributions of source code must retain the above copyright               |
  |    notice, this list of conditions and the following disclaimer.                |
  |                                                                                 |
  | 2. Redistributions in binary form must reproduce the above copyright            |
  |    notice, this list of conditions and the following disclaimer in the          |
  |    documentation and/or other materials provided with the distribution.         |
  |                                                                                 |
  | 3. All advertising materials mentioning features or use of this software        |
  |    must display the following acknowledgement:                                  |
  |    This product includes software developed by César D. Rodas.                  |
  |                                                                                 |
  | 4. Neither the name of the César D. Rodas nor the                               |
  |    names of its contributors may be used to endorse or promote products         |
  |    derived from this software without specific prior written permission.        |
  |                                                                                 |
  | THIS SOFTWARE IS PROVIDED BY CÉSAR D. RODAS ''AS IS'' AND ANY                   |
  | EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED       |
  | WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE          |
  | DISCLAIMED. IN NO EVENT SHALL CÉSAR D. RODAS BE LIABLE FOR ANY                  |
  | DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES      |
  | (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;    |
  | LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND     |
  | ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT      |
  | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS   |
  | SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE                     |
  +---------------------------------------------------------------------------------+
  | Authors: César Rodas <crodas@php.net>                                           |
  +---------------------------------------------------------------------------------+
*/
namespace Haanga2\Cli;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Finder\Finder;

/**
 *  Console Interface for Haanga2.
 *
 *  @package Haanga2
 *  @author Cesar D. Rodas
 */
class Build extends Console\Command\Command
{
    public function configure() {
        $this->setName('build')
            ->setDescription("Generate the phar file for haanga2");
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir    = dirname($_SERVER['PHP_SELF']);
        $output = $dir . '/haanga2.phar';
        $finder = new Finder();

        $phar = new \Phar($output, 0);

        // add vendors {{{
        $finder->files()
               ->name('*.php')
               ->in($dir . '/vendor');
        foreach ($finder as $file) {
            $phar->addFile($file->getRealPath(), substr($file, strlen($dir)));
        }
        // }}}

        // add haanga2 {{{
        $finder = new Finder();
        $finder->files()
               ->in($dir . '/lib');
        foreach ($finder as $file) {
            $phar->addFile($file->getRealPath(), substr($file, strlen($dir)));
        }
        // }}}

        $phar->setStub("#!/usr/bin/env php\n"
            . $phar->createDefaultStub('index.php')
        );
        $phar->addFile($_SERVER["PHP_SELF"], 'index.php');
        chmod($output, 0755);
    }
}
