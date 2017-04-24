<?php

namespace app\index\controller;

class Evaluation extends Base
{
    public function index ()
    {
        return $this->fetch();
    }
}