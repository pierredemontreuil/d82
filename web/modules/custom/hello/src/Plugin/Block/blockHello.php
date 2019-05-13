<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a hello block.
 *
 * @Block(
 *  id = "hello_blocl",
 *  admin_label = @Translation("Hello!")
 * )
 */
class blockHello extends BlockBase {
 /**
  * Implements Drupal\Core\Block\BlockBase::build().
  */
 public function build() {
     $build = [
         '#markup' => $this->t('Welcome %name on our site. It is %time.', [
             '%name' => \Drupal::service('current_user')->getDisplayName(),
             '%time' => \Drupal::service('date.formatter')
            ->format(\Drupal::service('datetime.time')->getCurrentTime(), 'custom', 'H:i s\s'),
     ]),
         '#cache' => [
            'keys' => ['hello:hello_block'],
            'cache_context' => 'user',
    ],
];
   return $build;
 }
}