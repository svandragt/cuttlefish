<?php

namespace Cuttlefish;

interface IPlugin
{
    public function load($pluginConfiguration);
    public function run();
    public function unload();
}
