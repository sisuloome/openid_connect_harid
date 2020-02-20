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
   * HarID test service base URL
   * @var string
   */
  const HARID_TEST_BASE_URL = 'https://test.harid.ee/et';

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['require_strong_session'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Require strong session'),
      '#description' => $this->t('If enabled, only users with strong sessions (ID-card or Mobile-ID) would be allowed.'),
      '#default_value' => $this->configuration['require_strong_session'],
    ];
    $form['use_test_idp'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use test Identity Provider'),
      '#description' => $this->t('If enabled, test.harid.ee will be used instead of hardi.ee.'),
      '#default_value' => $this->configuration['use_test_idp'],
    ];

    $url = 'https://harid.ee/en/pages/dev-info';
    $form['description'] = [
      '#markup' => '<div class="description">' . $this->t('Please follow <a href="@url" target="_blank">instructions</a> to setup HarID client.', ['@url' => $url]) . '</div>',
    ];

    return $form;
  }

  /**
   * Returns base URL for either live or test IdP service.
   *
   * @return string
   *   Base URL of IdP serivice
   */
  private function getBaseUrl() : string {
    if ($this->configuration['use_test_idp'] === TRUE) {
      return self::HARID_TEST_BASE_URL;
    }

    return self::HARID_BASE_URL;
  }

  /**
   * {@inheritdoc}
   */
  public function getEndpoints() {
    $base_url = $this->getBaseUrl();

    return [
      'authorization' => $base_url . '/authorizations/new',
      'token' => $base_url . '/access_tokens',
      'userinfo' => $base_url . '/user_info',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function authorize($scope = 'openid email') {
    // TODO See if we really need the personal_code scope to be present or it is
    // enough to use the session_type and check for the strong session
    return parent::authorize('openid profile email roles personal_code session_type');
  }

}
