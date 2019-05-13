<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a session block.
 *
 * @Block(
 *  id = "session",
 *  admin_label = @Translation("NbSessions:")
 * )
 */
class sessionblock extends BlockBase {
 /**
  * Implements Drupal\Core\Block\BlockBase::build().
  */
    protected function blockAccess(AccountInterface $account) {
        return AccessResult::allowedIfHasPermission($account, 'access hello');
    }


 public function build() {
     $number = \Drupal::database()->select('sessions')
         ->countQuery()
         ->execute()
         ->fetchfield();

   return [
       '#markup' => $this->t('There are %number actives sessions.', ['%number' => $number]),
       '#cache' => [
           'keys' => ['hello:sessions'],
           'max-age' => '0',
   ],
   ];
 }
}
