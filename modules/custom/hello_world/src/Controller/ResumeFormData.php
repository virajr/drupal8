<?php

/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

class ResumeFormData extends ControllerBase {

  public function resume_form_data() {

    $header = array('Name', 'Email', 'Numbar', 'Gender');

    $connection = \Drupal::database();
    $pager_data = $connection->select('application_form', 'dt');
    $pager_data->fields('dt');
    $table_sort = $pager_data->extend('Drupal\Core\Database\Query\TableSortExtender')->orderByHeader($header);
    $pager = $table_sort->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $pager_final_data = $pager->execute()->fetchAll();

    foreach ($pager_final_data as $result) {
      $rows[$result->app_id][] = $result->name;
      $rows[$result->app_id][] = $result->email;
      $rows[$result->app_id][] = $result->number;
      $rows[$result->app_id][] = $result->gender;
    }

    $build['location_table'] = array(
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows
    );

    $build['pager'] = array(
      '#type' => 'pager'
    );

    return $build;
  }

}
