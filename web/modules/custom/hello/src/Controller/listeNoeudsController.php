<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines HelloController class.
 */
class listeNoeudsController extends ControllerBase
{

    /**
     * Display the markup.
     *
     * @param string $nodetype
     * @return array
     */
    public function content($nodetype = NULL)
    {
        $storage = $this->entityTypeManager()->getStorage('node');
        $query = $storage->getQuery();
        if ($nodetype){
            $query->condition('type', $nodetype);
        }
        $ids = $query->pager(10)->execute();
        $nodes = $storage->loadMultiple($ids);
        $items = [];
        foreach ($nodes as $node) {
            $items[] = $node->toLink();
        }
        $list = [
            '#theme' => 'item_list',
            '#items' => $items,
        ];
        $pager = ['#type' => 'pager'];

        return [
            'list' => $list,
            'pager' => $pager,
            '#cache' => [
                'keys' => ['hello:node_list_controller'],
                'tags' => ['node_list'],
                'contexts' => ['url'],
            ],
        ];
    }
}
