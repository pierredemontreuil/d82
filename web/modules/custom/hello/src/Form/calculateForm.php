<?php

namespace Drupal\hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a hello form.
 */
class calculateForm extends FormBase {

  /**
  * {@inheritdoc}.
  */
    public function getFormID() {
        return 'hello_form';
    }

  /**
  * {@inheritdoc}.
  */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['value_1'] = array(
            '#type' => 'textfield',
            '#title' => 'First value',
            '#required' => 'TRUE',
            );
        $form['operation'] = array(
            '#type' => 'radios',
            '#title' => 'Operation',
            '#options' => array(
                'Addition' => $this->t('Add'),
                'Soustraction' => $this->t('substract'),
                'Multiplication' => $this->t('Multiply'),
                'Division' => $this->t('Divide'),
                )
            );
        $form['value_2'] = array(
            '#type' => 'textfield',
            '#title' => 'Second value',
            '#required' => 'TRUE',
            );

        $form['bouton'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Calculate'),
        );
        // recupération du resultat
        $result = $form_state->getRebuildInfo();
        if (isset($result['result'])) {
            $form['result'] = array (
                '#type' => 'html_tag',
                '#tag' => 'h2',
                '#value' => 'result: '.$result['result']
            );
        }
        return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state) {
        $value_1 = $form_state->getValue('value_1');
        if (!is_numeric($value_1)) {
            $form_state->setErrorByName('value_1', $this->t('Value 1 must be numeric'));
        }
        $value_2 = $form_state->getValue('value_2');
        if (!is_numeric($value_2)) {
            $form_state->setErrorByName('value_2', $this->t('Value 2 must be numeric'));
        }
        $operation = $form_state->getValue('operation');
        if ($value_2 == '0' && $operation == 'Division') {
            $form_state->setErrorByName('value_2', $this->t('Value 2 must be different from 0 For a divide'));
        }
        if (isset($form['result'])){
            unset($form['result']);
       }
    }

    /**
  * {@inheritdoc}.
  */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $value_1 = $form_state->getValue('value_1');
        $value_2 = $form_state->getValue('value_2');
        $operation = $form_state->getValue('operation');
        \Drupal::state()->set('hello_form_calculate_time', \Drupal::service('datetime.time')->getCurrentTime());
        $resultat = '';
        switch ($operation) {
            case 'Addition';
                $resultat = $value_1 + $value_2;
                break;
            case 'Soustraction';
                $resultat = $value_1 - $value_2;
                break;
            case 'Multiplication';
                $resultat = $value_1 * $value_2;
                break;
            case 'Division';
                $resultat = $value_1 / $value_2;
                break;
        }

//
//        (\Drupal::messenger())->addMessage($resultat);
//         on passe le resultat
        $form_state->addRebuildInfo('result', $resultat);
        // reconstructionn du formulaire
        $form_state->setrebuild();
    }

}
