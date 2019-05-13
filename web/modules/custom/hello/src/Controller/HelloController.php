<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines HelloController class.
 */
class HelloController extends ControllerBase {

    /**
     * Display the markup.
     *
     * @return array
     *   Return markup array.
     */
    public function content($param='') {
        $user = $this->currentUser();
        return ['#markup' => $this->t('Vous êtes sur la page Hello. Votre nom
d\'utilisateur est %name, et voici le paramètre dans l\’URL %param.',
            [
            '%name' => $user->getDisplayName(),
            '%param' => $param,]
        )];
    }}

