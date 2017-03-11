<?php

/**
 * @file
 * Contains \Drupal\resume\Form\ResumeForm.
 */

namespace Drupal\hello_world\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CsvUploadForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'csvupload_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['csvfile'] = array(
      '#type' => 'file',
      '#description' => 'Please click on choose file.',
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Upload'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    $validators = array(
      'file_validate_extensions' => 'csv',
    );

    $file = file_save_upload('csvfile', $validators, "public://", $delta = NULL, FILE_EXISTS_REPLACE);
    dpm($file->getValue('destination'));
    ksm($file);

//    if ($file) {
//      $form_state->getValue('csvfile') = $file->destination;
//    }
//    else {
//      $form_state->setErrorByName('csvfile', $this->t('Unable to copy upload file to destination'));
//    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    dsm($form_state->getValue('csvupload'));

//    if (isset($form_state->getValue('csvupload'))) {
//
//      $variable = $fields = array();
//      $i = 0;
//      $handle = @fopen($form_state->getValue('csvupload'), "r");
//      if ($handle) {
//        while (($row = fgetcsv($handle, 4096)) !== false) {
//          if (empty($fields)) {
//            $fields = $row;
//            continue;
//          }
//          foreach ($row as $k => $value) {
//            $variable[$i][strtolower($fields[$k])] = $value;
//          }
//          $i++;
//        }
//        if (!feof($handle)) {
//          echo "Error: unexpected fgets() fail\n";
//        }
//        fclose($handle);
//      }
//    }
//    dsm($variable);
  }

}
