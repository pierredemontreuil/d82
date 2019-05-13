<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\UserInterface;

/**
 * Defines HelloController class.
 */
class userStatisticsController extends ControllerBase
{


    /**
     * Display the markup.
     *
     * @param string $nodetype
     * @return array
     */
    public function content(UserInterface $user)
    {
        $results = \Drupal::database()
            ->select('hello_user_statistics', 'hus')
            ->fields('hus', ['action', 'time'])
            ->condition('uid', $user->id())
            ->execute();
        $rows = [];
        $count = 0;
        foreach ($results as $record) {
            $rows[] = [
                $record->action == '1' ? $this->t('login') : $this->t('logout'),
                \Drupal::service('date.formatter')->format($record->time),
            ];
            $count += $record->action; 
        }
        $output = [
          '#theme' => 'hello',
          '#data' => ['user' => $user->label(), 'count' => $count],
        ];
        $table = [
            '#type' => 'table',
            '#header' => [$this->t('Action'), $this->t('Time')],
            '#rows' => $rows,
        ];
        return [$output, $table];
    }
}
