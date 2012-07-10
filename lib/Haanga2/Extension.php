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
namespace Haanga2;

use Notoj\File as FileParser,
    Symfony\Component\Finder\Finder;

class Extension 
{
    protected $tags = array();
    protected $tokenizer = NULL;
    protected $scanned = array();

    public function __construct(Compiler\Tokenizer $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    public function getTag($tag)
    {
        if (!isset($this->tags[$tag])) {
            throw new \RuntimeException("Cannot find tag {$tag}");
        }
        return $this->tags[$tag];
    }

    public function addDirectory($dir)
    {
        if (!is_dir($dir)) {
            throw new \RuntimeException("{$dir} is not a valid directory");
        }
        if (isset($this->scanned[$dir])) {
            return $this;
        }

        $this->scanned[$dir] = true;

        $files = new Finder;
        $files->files()
            ->in($dir)
            ->name("*.php");

        foreach ($files as $file) {
            $parser = new FileParser($file->getRealPath());
            foreach ($parser->getAnnotations() as $obj) {
                foreach ($obj['annotations']->get('Haanga2\\Tag') as $tag) {
                    if (empty($tag['args']['name'])) {
                        throw new \RuntimeException("in {$file} one tag has no name on line {$obj['line']}");
                    }
                    $callback = array();
                    foreach (array('class', 'function') as $type) {
                        if (isset($obj[$type])) {
                            $callback[] = $obj[$type];
                        }
                    }

                    if (count($callback) == 1) {
                        $callback = $callback[0];
                    }

                    $name  = $tag['args']['name'];
                    $block = !empty($tag['args']['block']);
                    $this->tags[$name] = array_merge($tag['args'], array(
                        'block'     => $block,
                        'callback'  => $callback,
                        'file'      => $obj['file'],
                    ));
                    $this->tokenizer->registerTag($name, $block);
                }
            }
        }

        return $this;
    }

}
