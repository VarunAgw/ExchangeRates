<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use Cake\ORM\TableRegistry;
use App\Utility\FixerIo;

/**
 * ExchangeRates Model
 *
 * @property \App\Model\Table\CurrenciesTable|\Cake\ORM\Association\BelongsTo $BaseCurrencies
 * @property \App\Model\Table\CurrenciesTable|\Cake\ORM\Association\BelongsTo $TargetCurrencies
 *
 * @method \App\Model\Entity\ExchangeRate get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExchangeRate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ExchangeRate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExchangeRate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExchangeRate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExchangeRate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExchangeRate findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExchangeRatesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('exchange_rates');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('BaseCurrencies', [
            'className' => 'Currencies',
            'foreignKey' => 'base_currency_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TargetCurrencies', [
            'className' => 'Currencies',
            'foreignKey' => 'target_currency_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->decimal('base_currency_id')
            ->requirePresence('base_currency_id', 'create')
            ->notEmpty('base_currency_id');

        $validator
            ->decimal('base_amount')
            ->requirePresence('base_amount', 'create')
            ->notEmpty('base_amount');

        $validator
            ->decimal('target_currency_id')
            ->requirePresence('target_currency_id', 'create')
            ->notEmpty('target_currency_id');

        $validator
            ->decimal('target_amount')
            ->allowEmpty('target_amount');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['base_currency_id'], 'BaseCurrencies'));
        $rules->add($rules->existsIn(['target_currency_id'], 'TargetCurrencies'));

        return $rules;
    }
    
    public function getExchangeRate($baseCurrencyId, $targetCurrencyId) {
        $Currencies = TableRegistry::get('Currencies');

        $baseCurrency = $Currencies->get($baseCurrencyId)->symbol;
        $targetCurrency = $Currencies->get($targetCurrencyId)->symbol;

        $exchangeRate = (new FixerIo())->getExchangeRate($baseCurrency, $targetCurrency);
        return $exchangeRate;
    }
}
