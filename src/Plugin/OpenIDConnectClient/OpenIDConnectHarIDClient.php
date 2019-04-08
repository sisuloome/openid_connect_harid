<?php

namespace Drupal\openid_connect_harid\Plugin\OpenIDConnectClient;

use Drupal\Core\Form\FormStateInterface;
use Drupal\openid_connect\Plugin\OpenIDConnectClientBase;

/**
 * HarID OpenID Connect client.
 *
 * Implements OpenID Connect Client plugin for HarID.
 *
 * @OpenIDConnectClient(
 *   id = "harid",
 *   label = @Translation("HarID")
 * )
 */
class OpenIDConnectHarIDClient extends OpenIDConnectClientBase {

  /**
   * HarID service base URL
   * @var string
   */
  const HARID_BASE_URL = 'https://harid.ee/et';

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $url = 'https://harid.ee/en/pages/dev-info';
    $form['description'] = [
      '#markup' => '<div class="description">' . $this->t('Please follow <a href="@url" target="_blank">instructions</a> to setup HarID client.', ['@url' => $url]) . '</div>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getEndpoints() {
    return [
      'authorization' => self::HARID_BASE_URL . '/authorizations/new',
      'token' => self::HARID_BASE_URL . '/access_tokens',
      'userinfo' => self::HARID_BASE_URL . '/user_info',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function authorize($scope = 'openid email') {
    return parent::authorize('openid profile email roles');
  }

}
