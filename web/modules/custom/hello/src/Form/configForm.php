<?php

namespace Drupal\Hello\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *  Implements an admin form
 */
class configForm extends ConfigFormBase
{
    /**
     *  {@inheritdoc),
     */
    public function getFormID() {
        return 'admin_form';
    }

    /**
     *  {@inheritdoc),
     */
    protected function getEditableConfigNames() {
        return ['hello.settings'];
    }

    /**
     *  {@inheritdoc),
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['select'] = array(
            '#type' => 'select',
            '#title' => $this->t('Days number conservation'),
            '#options' => array(
                '0' => $this->t('0 day'),
                '1' => $this->t('1 day'),
                '2' => $this->t('2 days'),
                '7' => $this->t('7 days'),
                '14' => $this->t('14 days'),
                '30' => $this->t('30 days'),
            ),
            '#default_value' => $this->config('hello.settings')->get('purge_days_number'),
        );
        return parent::buildForm($form, $form_state);
    }

    /**
     *  {@inheritdoc),
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $purge_days_number = $form_state->getValue('select');
      $this->config('hello.settings')->set('purge_days_number', $purge_days_number)->save(); 
      parent::submitForm($form, $form_state);

    }
}
