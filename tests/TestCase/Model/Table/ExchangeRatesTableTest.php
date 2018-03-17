<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExchangeRatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExchangeRatesTable Test Case
 */
class ExchangeRatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExchangeRatesTable
     */
    public $ExchangeRates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.exchange_rates',
        'app.base_currencies',
        'app.target_currencies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ExchangeRates') ? [] : ['className' => ExchangeRatesTable::class];
        $this->ExchangeRates = TableRegistry::get('ExchangeRates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ExchangeRates);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getExchangeRate method
     *
     * @return void
     */
    public function testGetExchangeRate()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
