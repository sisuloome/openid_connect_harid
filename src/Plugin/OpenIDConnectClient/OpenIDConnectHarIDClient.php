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
      'authorization' => 'https://harid.ee/et/authorizations/new',
      'token' => 'https://harid.ee/et/access_tokens',
      'userinfo' => 'https://harid.ee/et/user_info',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function authorize($scope = 'openid email') {
    return parent::authorize('openid profile email roles');
  }

}
