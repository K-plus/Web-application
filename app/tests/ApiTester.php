<?php

use Faker\Factory as Faker;

/**
 * Class ApiTester
 */
abstract class ApiTester extends TestCase {

    /**
     * @var \Faker\Generator
     */
    protected $fake;

    /**
     * @var int
     */
    protected $times = 1;

    /**
     *
     */
    function __construct()
    {
        $this->fake = Faker::create();
    }

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->app['artisan']->call('migrate');
        $this->app['router']->enableFilters();
    }

    /**
     * @param $count
     * @return $this
     */
    protected function times($count)
    {
        $this->times = $count;

        return $this;
    }

    /**
     * @param $type
     * @param array $fields
     */
    protected function make($type, array $fields = [])
    {
        $stub = array_merge($this->getStub(), $fields);

        $type::create($stub);
    }

    /**
     *
     */
    protected function getStub()
    {
        throw new BadMethodCallException('Create your own method to declare your fields.');
    }

    /**
     * @param $uri
     * @return mixed
     */
    protected function getJson($uri)
    {
        return json_decode($this->call('GET', $uri)->getContent());
    }

    /**
     * @param $uri
     * @return mixed
     */
    protected function postJson($uri, $params)
    {
        return json_decode($this->call('POST', $uri, $params)->getContent());
    }

    /**
     *
     */
    protected function assertObjectHasAttributes()
    {
        $args = func_get_args();
        $object = array_shift($args);

        foreach ($args as $attribute) {
            $this->assertObjectHasAttribute($attribute, $object);
        }
    }

} 