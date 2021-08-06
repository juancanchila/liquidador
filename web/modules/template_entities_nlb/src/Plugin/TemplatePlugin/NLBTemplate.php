<?php

namespace Drupal\template_entities_nlb\Plugin\TemplatePlugin;

use Drupal\Component\Plugin\DependentPluginInterface;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Plugin\PluginWithFormsInterface;
use Drupal\node_layout_builder\NodeLayoutBuilderEditor;
use Drupal\node_layout_builder\Services\NodeLayoutBuilderManager;
use Drupal\template_entities\Entity\Template;
use Drupal\template_entities\Plugin\TemplatePlugin\NodeTemplate;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Template plugin for Node Layout Builder.
 *
 *
 * This does not override any derived plugin.
 *
 * @TemplatePlugin(
 *   id = "nlb",
 *   label = @Translation("Content with Node Layout Builder"),
 *   entity_type_id = "node"
 * )
 */
class NLBTemplate extends NodeTemplate implements DependentPluginInterface, PluginWithFormsInterface {

  /**
   * The book manager.
   *
   * @var \Drupal\node_layout_builder\Services\NodeLayoutBuilderManager
   */
  protected NodeLayoutBuilderManager $nlbManager;

  /**
   * Current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $nlb_template_plugin = parent::create($container, $configuration, $plugin_id, $plugin_definition);

    $nlb_template_plugin->nlbManager = $container->get('node_layout_builder.manager');
    $nlb_template_plugin->currentUser = $container->get('current_user');

    return $nlb_template_plugin;
  }

  /**
   * {@inheritdoc}
   */
  public function alterDuplicateEntity(EntityInterface $entity) {
    parent::alterDuplicateEntity($entity);

    /** @var \Drupal\node\Entity\Node $duplicate_node */
    $duplicate_node = $entity;

    return $duplicate_node;
  }

  /**
   * @inheritDoc
   */
  public function duplicateEntityInsert(EntityInterface $entity) {
    parent::duplicateEntityInsert($entity);

    /** @var \Drupal\node\Entity\Node $duplicate_node */
    $duplicate_node = $entity;

    /** @var Template $template */
    $template = $duplicate_node->template;

    /** @var \Drupal\node\Entity\Node $original_node */
    $original_node = $template->getSourceEntity();

    $uuid = $this->currentUser->id();

    // Get data layout node from cache.
    $data = $this->nlbManager::loadDataElement($original_node->id());

    NodeLayoutBuilderEditor::saveElementEntity($entity->id(), $uuid, $data);
  }

  /**
   * {@inheritdoc}
   */
  public function calculateDependencies() {
    // Add node_layout_builder module as a dependency.
    return NestedArray::mergeDeep(
      parent::calculateDependencies(),
      ['module' => ['node_layout_builder']],
    );
  }

  /**
   * @inheritDoc
   */
  public function getBundleOptions() {
    // Only return bundles that can be used with node_layout_builder.
    $nlbManager = $this->nlbManager;
    return array_filter(parent::getBundleOptions(), function($bundle) use ($nlbManager) {
      return $nlbManager->canUseNodeLayoutBuilder($bundle);
    }, ARRAY_FILTER_USE_KEY);

  }

}

