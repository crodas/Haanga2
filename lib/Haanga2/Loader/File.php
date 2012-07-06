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
namespace Haanga2\Loader;

use Artifex,
    Haanga2\Loader;

class File implements Loader
{
    protected $paths = array();

    public function addPath($dir, $prepend = false)
    {
        if (!is_dir($dir) || !is_readable($dir)) {
            throw new \RuntimeException("{$dir} is an invalid directory");
        }
        if ($prepend) {
            array_unshift($this->paths, $dir . 'x');
        } else {
            $this->paths[] = $dir;
        }

        return $this;
    }

    protected function getTplPath($tpl)
    {
        foreach ($this->paths as $path) {
            if (is_file($path . '/' . $tpl)) {
                $path = $path . '/' . $tpl;
                break;
            }
        }

        if (empty($path)) {
            throw new \RuntimeException("cannot find template {$tpl}");
        }

        return realpath($path);
    }

    public function getTplId($tpl)
    {
        return sha1($path);
    }

    public function save($tpl, $code)
    {
        $path = $this->getTplPath($tpl);
        $callback = 'haanga2_' . $this->getTplId($path);
        $compiled = $this->output . '/' . $callback . '.php';
        
        // we do not care if this fails
        Artifex::save($compiled, $code);
    }

    public function load($tpl)
    {
        $path = $this->getTplPath($tpl);
        $callback = 'haanga2_' . $this->getTplId($path);
        if (is_callable($callback)) {
            return $callback;
        }
        
        $compiled = $this->output . '/' . $callback . '.php';
        if (is_file($compiled) && filemtime($compiled) > filemtime($path)) { 
            /* load the compiled php only if the compiled
               version is newer than our tpl file */
            require $compiled;
            if (is_callable($callback)) {
                return $callback;
            }
        }

        /* we can't find it, it should be recompiled */
        return false;
    }

    public function getContent($tpl)
    {
        return file_get_contents($this->getTplPath($tpl));
    }
}
