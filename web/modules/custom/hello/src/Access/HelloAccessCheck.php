<?php

namespace Drupal\hello\Access;

use Drupal\Core\Access\AccessCheckInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Access\AccessResult;

class HelloAccessCheck implements AccessCheckInterface {

    public function applies(Route $route) {
        return NULL;
    }

    public function access(Route $route, Request $request = NULL, AccountInterface $account) {
        $nbr_heures = $route->getRequirement('_access_hello');
//ksm($account);
    if (!$account->isAnonymous() &&
        /** @var ^$account \Drupal\Core\Session\AccountProxy */
        (\Drupal::time()->getCurrentTime() - $account->getAccount()->created > $nbr_heures * 3600)) {
        // on récupère la date courante moins la date de création du compte
         return AccessResult::allowed()->cachePerUser(); // mise en cache pour éviter qu'un autre user récupère les données
    }
        return AccessResult::forbidden()->cachePerUser();
    }
}
