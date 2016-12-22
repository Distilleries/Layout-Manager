<?php
/**
 * Created by PhpStorm.
 * User: cross
 * Date: 2/24/2015
 * Time: 11:46 AM
 */

use \Mockery as m;

class LayoutManagerTest extends \Orchestra\Testbench\TestCase {

    protected $guard;
    protected $auth;

    public function setUp()
    {
        parent::setUp();
    }

    protected function getPackageProviders()
    {
        return [ 'Distilleries\LayoutManager\LayoutManagerServiceProvider' ];
    }

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }
}
