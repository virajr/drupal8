<?php

/**
 * @file
 * Contains \Drupal\resume\Form\ResumeForm.
 */

namespace Drupal\hello_world\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class TableSelectForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tableselect_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $connection = \Drupal::database();
    $pager_data = $connection->select('application_form', 'dt');
    $pager_data->fields('dt');
    $pager_final_data = $pager_data->execute()->fetchAll();

    foreach ($pager_final_data as $result) {
      $key = $result->app_id . '::' . $result->name . '::' . $result->email . '::' . $result->number . '::' . $result->gender;
      $options[$key] = array(
        'app_id' => $result->app_id,
        'name' => $result->name,
        'email' => $result->email,
        'number' => $result->number,
        'gender' => $result->gender,
      );
    }

    $header = array(
      'app_id' => t('App ID'),
      'name' => t('Name'),
      'email' => t('Email'),
      'number' => t('Number'),
      'gender' => t('Gender'),
    );

    $form['table'] = array(
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $options,
      '#empty' => t('No users found'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $table_values = $form_state->getValue('table');
    foreach ($table_values as $value) {
      if ($value != '0') {
        $data = explode('::', $value);
        // Create node object with attached file.
        $node = Node::create([
              'type' => 'user_application',
              'title' => 'Application by user ' . $data[1],
              'field_user_email' => $data[2],
              'field_user_name' => $data[1],
              'body' => $data[4],
        ]);
        $node->save();
      }
    }
    drupal_set_message('Data saved successfully !');
  }

}
