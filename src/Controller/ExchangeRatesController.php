<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ExchangeRates Controller
 *
 * @property \App\Model\Table\ExchangeRatesTable $ExchangeRates
 *
 * @method \App\Model\Entity\ExchangeRate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExchangeRatesController extends AppController
{

    /**
     * Index method
     *
     */
    public function index()
    {
        $exchangeRate = $this->ExchangeRates->newEntity();

        if ($this->request->is('post')) {
            $exchangeRate = $this->ExchangeRates->patchEntity($exchangeRate, $this->request->getData());

            if ($exchangeRate->errors()) {
                return $this->Flash->error(__('Error validating data. Please try again!'));
            }

            $rate = $this->ExchangeRates->getExchangeRate($exchangeRate->base_currency_id, $exchangeRate->target_currency_id);

            $targetAmount = round($exchangeRate->base_amount * $rate, 2);
            $this->set('targetAmount', $targetAmount);
            $this->Flash->success(__('Successfully converted amount in target currency'));
        }

        $baseCurrencies = $this->ExchangeRates->BaseCurrencies->find('list', ['limit' => 200]);
        $targetCurrencies = $this->ExchangeRates->TargetCurrencies->find('list', ['limit' => 200]);
        $this->set(compact('exchangeRate', 'baseCurrencies', 'targetCurrencies'));
    }

}
