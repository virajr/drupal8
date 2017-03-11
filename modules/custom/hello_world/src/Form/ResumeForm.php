<?php

/**
 * @file
 * Contains \Drupal\resume\Form\ResumeForm.
 */

namespace Drupal\hello_world\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ResumeForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'resume_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate Name:'),
      '#required' => TRUE,
    );

    $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
    );

    $form['candidate_number'] = array(
      '#type' => 'tel',
      '#title' => t('Mobile no'),
    );

    $form['candidate_gender'] = array(
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'Female' => t('Female'),
        'male' => t('Male'),
      ),
    );

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('candidate_number')) < 10) {
      $form_state->setErrorByName('candidate_number', $this->t('Mobile number is too short.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    drupal_set_message($this->t('Hello @can_name ,Your application is being submitted!', array('@can_name' => $form_state->getValue('candidate_name'))));

    $db = \Drupal::database();
    $result = $db->insert('application_form')
            ->fields(array(
              'name' => $form_state->getValue('candidate_name'),
              'email' => $form_state->getValue('candidate_mail'),
              'number' => $form_state->getValue('candidate_number'),
              'gender' => $form_state->getValue('candidate_gender'),
            ))->execute();
  }

}
