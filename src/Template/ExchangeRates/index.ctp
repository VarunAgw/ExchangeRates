<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExchangeRate $exchangeRate
 */
?>

<div class="exchangeRates form large-9 medium-8 columns content">
    <?= $this->Form->create($exchangeRate) ?>
    <fieldset>
        <legend><?= __('Exchange Currency') ?></legend>
        <?php
            echo $this->Form->control('base_currency_id');
            echo $this->Form->control('base_amount');
            echo $this->Form->control('target_currency_id');
            if (!empty($targetAmount)) {
                echo $this->Form->control('target_amount', ['val' => $targetAmount, 'disabled']);
            }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Calculate Amount')) ?>
    <?= $this->Form->end() ?>
</div>
