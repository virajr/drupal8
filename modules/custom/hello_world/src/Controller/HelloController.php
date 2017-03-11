<?php

/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

  public function content() {
    
    $output = '<h1>Hello, World!</h1>
      <div role="contentinfo" aria-label="Status message" class="messages messages--status">
                    Hook menu is working fine !!
            </div>';
    
    return array(
      '#type' => 'markup',
      '#markup' => $this->t($output),
    );
  }

}
