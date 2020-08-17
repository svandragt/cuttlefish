<?php

namespace Cuttlefish;

interface iPlugin {
    public function load($pluginConfiguration);
    public function run();
    public function unload();
}