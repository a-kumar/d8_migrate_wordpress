<?php

/**
 * @file
 * Contains \Drupal\migrate_wordpress\Plugin\migrate\source\Comments.
 */

namespace Drupal\migrate_wordpress\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\migrate\Plugin\SourceEntityInterface;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Wordpress posts source from database.
 *
 * @MigrateSource(
 *   id = "comments"
 * )
 */
class Comments extends DrupalSqlBase implements SourceEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Select approved comments.
    $query = $this->select('wp_comments', 'c')
      ->fields('c', array_keys($this->commentFields()))
      ->condition('comment_approved', '1', '=');

    return $query;
  }

  /**
   * Returns the Comments fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function commentFields() {
    $fields = array(
      'comment_ID' => $this->t('Comment ID'),
      'comment_post_ID' => $this->t('Comment post ID'),
      'comment_author' => $this->t('Comment author'),
      'comment_author_email' => $this->t('Comment author email'),
      'comment_author_url' => $this->t('Comment author homepage'),
      'comment_author_IP' => $this->t('Comment author ip'),
      'comment_date' => $this->t('Comment date'),
      'comment_content' => $this->t('Comment body'),
      'comment_approved' => $this->t('Comment approved'),
      'comment_parent' => $this->t('Comment parent'),
      'user_id' => $this->t('Authored by'),
    );
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->commentFields();
    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function bundleMigrationRequired() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function entityTypeId() {
    return 'comment';
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'comment_ID' => array(
        'type' => 'integer',
        'alias' => 'c',
      ),
    );
  }

}
