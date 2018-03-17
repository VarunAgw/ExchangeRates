<?php

namespace App\Shell;

use Cake\Console\Shell;

use App\Utility\FixerIo;
use Cake\ORM\TableRegistry;

/**
 * Currency related shell functions
 */
class CurrencyShell extends Shell
{

    /**
     * Start the shell and interactive console.
     *
     * @return int|null
     */
    public function main()
    {
        echo 'Run `php bin/cake.php currency refresh` to load new currencies in database' . PHP_EOL;
    }

    /**
     * Display help for this console.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function refresh() {
        $CurrenciesTable = TableRegistry::get('Currencies');

        $fixerCurrencies = (new FixerIo)->getCurrencyList();
        $dbCurrencies = $CurrenciesTable->find('list', ['displayField' => 'symbol'])->toArray();

        // Find new currency that doesn't exist in database
        $newCurrencies = array_diff($fixerCurrencies, $dbCurrencies);

        // Save new currencies in database
        foreach ($newCurrencies as &$newCurrency) {
            $newCurrency = ['symbol' => $newCurrency];
        }
        $entities = $CurrenciesTable->newEntities($newCurrencies);
        $CurrenciesTable->saveMany($entities);
        
        echo sprintf(__('Currencies found in fixer.io = %d'), count($fixerCurrencies)). PHP_EOL;
        echo sprintf(__('Newly saved currencies in database = %d'), count($newCurrencies)). PHP_EOL;
        echo sprintf(__('Total currencies in database now = %d'), TableRegistry::get('Currencies')->find('list')->count()) . PHP_EOL;
    }

}
