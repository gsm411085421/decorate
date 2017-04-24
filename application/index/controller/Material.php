<?php

namespace app\index\controller;

class Material extends Base
{
    public function index ()
    {
        return $this->fetch();
    }
}