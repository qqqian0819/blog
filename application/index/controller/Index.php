<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    public function home()
    {
        return $this->fetch();
    }
    public function life()
    {
        return $this->fetch();
    }
    public function message()
    {
        return $this->fetch();
    }
    public function detail()
    {
        return $this->fetch();
    }

}
