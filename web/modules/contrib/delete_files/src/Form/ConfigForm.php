<?php

namespace Drupal\delete_files\Form;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ConfigForm, a Drupal form extending ConfigFormBase.
 *
 * Space & weight to do more useful things around configuring what to do with
 * deleted files & which files to show.
 *
 * @package Delete_Files
 * @link https://www.drupal.org/project/delete_files
 */
class ConfigForm extends ConfigFormBase {
  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  private $currentUser;

  /**
   * The Module Handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a ConfigForm object.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $currentUser
   *   The current user.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The Module Handler service.
   */
  public function __construct(AccountProxyInterface $currentUser, ModuleHandlerInterface $moduleHandler) {
    $this->currentUser = $currentUser;
    $this->moduleHandler = $moduleHandler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
      $container->get('module_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'delete_files_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return [
      'delete_files.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('delete_files.settings');

    $form['address_description'] = [
      '#markup' => $this->t('Delete files'),
      '#prefix' => '<h2>',
      '#suffix' => '</h2>',
    ];

    $form['num_per_page'] = [
      '#title' => $this->t('Number of files to show per tab'),
      '#type' => 'textfield',
      '#default_value' => $config->get('num_per_page'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /*
  public function validateForm(array &$form, FormStateInterface $form_state) {
  // To do - the current config form is space & weight only.
  } */

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('delete_files.settings')
      ->set('num_per_page', (int) $form_state->getValue('num_per_page'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
