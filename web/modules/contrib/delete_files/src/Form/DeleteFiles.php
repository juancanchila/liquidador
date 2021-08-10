<?php

namespace Drupal\delete_files\Form;

// Use Drupal\Core\Pager\RequestPagerInterface;.
use Drupal\Core\Pager\PagerParameters;
use Drupal\Core\Pager\PagerManagerInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileSystem;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StreamWrapper\StreamWrapperManagerInterface;

/**
 * Class DeleteFiles, a Drupal form extending FormBase.
 *
 * @package Delete_Files
 * @link https://www.drupal.org/project/delete_files
 */
class DeleteFiles extends FormBase {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The file_system service.
   *
   * @var \Drupal\Core\File\FileSystem
   */
  protected $fileSystem;

  /**
   * The messanger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The pager manager service.
   *
   * @var \Drupal\Core\Pager\PagerManagerInterface
   */
  protected $pagerManager;

  /**
   * The pager request service.
   *
   * @var \Drupal\Core\Pager\PagerParameters
   */
  protected $requestPager;

  /**
   * The stream service.
   *
   * @var Drupal\Core\StreamWrapper\StreamWrapperManagerInterface
   */
  protected $streamWrapperManager;

  /**
   * The resolved path of the files directory on the server.
   *
   * @var string
   */
  protected $physicalBasePathStr;

  /**
   * The length of the physical file directory path string.
   *
   * @var int
   */
  protected $physicalBasePathStrLen;

  /**
   * The URL of the files directory.
   *
   * @var string
   */
  protected $webBasePathStr;

  /**
   * The length of the URL of the files directory.
   *
   * @var int
   */
  protected $webBasePathStrLen;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Session\AccountProxy $currentUser
   *   Current user service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type manager.
   * @param \Drupal\Core\File\FileSystem $fileSystem
   *   File system service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   Messanger service.
   * @param \Drupal\Core\Pager\PagerManagerInterface $pagerManager
   *   Pager manager service.
   * @param \Drupal\Core\Pager\PagerParameters $requestPager
   *   Pager request service.
   * @param Drupal\Core\StreamWrapper\StreamWrapperManagerInterface $streamWrapperManager
   *   Stream service.
   *
   *   Problematic: setStringTranslation is called separately.
   */
  public function __construct(
        AccountProxy $currentUser,
        EntityTypeManagerInterface $entityTypeManager,
        FileSystem $fileSystem,
        MessengerInterface $messenger,
        PagerManagerInterface $pagerManager,
        PagerParameters $requestPager,
        StreamWrapperManagerInterface $streamWrapperManager
    ) {
    // The formbase class also has a currentUser() function.
    $this->currentUser = $currentUser;
    $this->entityTypeManager = $entityTypeManager;
    $this->fileSystem = $fileSystem;
    $this->messenger = $messenger;
    $this->pagerManager = $pagerManager;
    $this->requestPager = $requestPager;
    $this->streamWrapperManager = $streamWrapperManager;

    $this->initPaths();
  }

  /**
   * Dependency injection via factory method, overrides the base class.
   *
   * Dependency injection that we inherit!
   *
   * @param \Drupal\Core\DependencyInjection\ContainerInterface $container
   *   Container to get traits.
   *
   * @return class
   *   A new instance of this class.
   */
  public static function create(ContainerInterface $container) {
    $form = new static(
          $container->get('current_user'),
          $container->get('entity_type.manager'),
          $container->get('file_system'),
          $container->get('messenger'),
          $container->get('pager.manager'),
          $container->get('pager.parameters'),
          $container->get('stream_wrapper_manager')
      );
    // Sloppy doing this one separatley.
    $form->setStringTranslation($container->get('string_translation'));
    return $form;
  }

  /**
   * Identify the form, overrides the base class.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'delete_files_page_delete_files';
  }

  /**
   * Form constructor, overrides the base class.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Global $base_url;.
    $form['files'] = [
      '#type' => 'tableselect',
      '#title' => 'Files',
      '#header' => [
        'file_name' => $this->t('File Name'),
      ],
      '#multiple' => TRUE,
      '#js_select' => FALSE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      '#weight' => -99,
    ];

    if ($this->currentUser->hasPermission('delete files')) {
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Delete selected files'),
      ];

      $form['description'] = [
        '#type' => 'item',
        '#markup' => $this->t(
            "<p>Files managed by Drupal in the file_managed table and on the Files tab are replaced by a blank file when they're deleted.</p>"
        ),
        '#weight' => -98,
      ];
    }
    else {
      $form['description'] = [
        '#type' => 'item',
        '#markup' =>
        $this->t('<p>Additional permissions required to delete files.</p>'),
        '#weight' => -98,
      ];
    }

    // For future development.
    $showHiddenFiles = TRUE;

    $public_dir = $this->fileSystem
      ->realpath(\Drupal::config('system.file')->get('default_scheme') . "://");
    $files_arr = DeleteFiles::dirContents($public_dir, $showHiddenFiles);
    $files_arr = array_filter($files_arr, [$this, 'writable']);

    $num_per_page = \Drupal::config('delete_files.settings')->get('num_per_page');
    $page = $this->requestPager->findPage();
    $this->pagerManager->createPager(count($files_arr), $num_per_page)->getCurrentPage();
    $form['pager'] = [
      '#type' => 'pager',
    ];
    $page_array = array_slice($files_arr, $num_per_page * $page, $num_per_page, TRUE);

    foreach ($page_array as $obj) {
      if ($obj['have_link']) {
        $form['files']['#options'][$obj['path']]['file_name']['data'] = [
          '#type' => 'item',
          '#markup' =>
          '<a href="'
          . $this->pyhsicalToWebAddress($obj['path'])
          . '">'
          . $this->physicalToShortWebAddress($obj['path'])
          . '</a>',
        ];
      }
      else {
        $form['files']['#options'][$obj['path']]['file_name']['data'] = [
          '#type' => 'item',
          '#markup' => $this->physicalToShortWebAddress($obj['path']),
        ];
      }
    }

    return $form;
  }

  /**
   * Form submission handler, overrides the base class.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($this->currentUser->hasPermission('delete files')) {
      $results = $form_state->getValues()['files'];
      foreach ($results as $val) {
        if ($val) {
          $web_short_address = $this->physicalToShortWebAddress($val);
          $this->fileSystem->delete($val);
          if ($this->managedFile(\Drupal::config('system.file')->get('default_scheme') . ':/' . $web_short_address)) {
            touch($val);
            $this->messenger->addMessage(
                  $this->t('Blanked:')
                  . ' '
                  . $web_short_address
              );
          }
          else {
            $this->messenger->addMessage(
                  $this->t('Deleted:')
                  . ' '
                  . $web_short_address
              );
          }
        }
      }
    }
  }

  /**
   * Init_paths.
   *
   *   Set up the file paths $physicalBasePathStr, and
   *   $webBasePathStr.
   */
  protected function initPaths() {
    $default_scheme = \Drupal::config('system.file')->get('default_scheme') . "://";
    $this->physicalBasePathStr = rtrim($this->fileSystem->realpath($default_scheme), '\/');
    $this->physicalBasePathStrLen = strlen($this->physicalBasePathStr);

    $wrapper = $this->streamWrapperManager->getViaUri($default_scheme);
    $this->webBasePathStr = rtrim($wrapper->getExternalUrl(), '\/');
    $this->webBasePathStrLen = strlen($this->webBasePathStr);
  }

  /**
   * Does this file contain this string?
   *
   * @param string $file_path
   *   Path to the file.
   * @param string $string
   *   String to search for.
   *
   * @return bool
   *   Whether it does
   */
  public static function containsString($file_path, $string) {
    $handle = fopen($file_path, 'r');
    while (($buffer = fgets($handle)) !== FALSE) {
      if (strpos($buffer, $string) !== FALSE) {
        fclose($handle);
        return TRUE;
      }
    }
    fclose($handle);
    return FALSE;
  }

  /**
   * The contents of a directory.
   *
   * @param string $dir
   *   The path of the directory.
   * @param bool $showHiddenFiles
   *   Whether to show hidden files.
   * @param string|bool[] $results
   *   Used to pass the returned results recursively.
   *
   * @return string|bool[]
   *   Inner array of 'path' (string) & 'have_link' (bool),
   *   have_link indicates whether to show a link, where
   *   FALSE indicates the link would just 403.
   */
  public static function dirContents($dir, $showHiddenFiles, &$results = []) {
    $files = scandir($dir);
    $see_files = TRUE;
    $have_link = TRUE;

    foreach ($files as $name) {
      $path = realpath($dir . DIRECTORY_SEPARATOR . $name);
      if ($name == '.htaccess'
            && DeleteFiles::containsString($path, 'Require all denied')
        ) {
        if (!$showHiddenFiles) {
          $see_files = FALSE;
        }
        $have_link = FALSE;
        break;
      }
    }

    foreach ($files as $name) {
      $path = realpath($dir . DIRECTORY_SEPARATOR . $name);
      if (!is_dir($path) && $see_files) {
        $results[] = ['path' => $path, 'have_link' => $have_link];
      }
      elseif ($name != '.' && $name != '..') {
        DeleteFiles::dirContents($path, $showHiddenFiles, $results);
      }
    }
    return $results;
  }

  /**
   * Is the file managed by Drupal?
   *
   * @param string $uri
   *   The file path.
   *
   * @return bool
   *   Whether it is a managed file.
   */
  public function managedFile($uri) {
    $fid = $this->entityTypeManager
      ->getStorage('file')
      ->getQuery()
      ->condition('uri', $uri)
      ->execute();
    if (!empty($fid)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * URL of the file folder.
   *
   * @param string $path
   *   The server path to translate.
   *
   * @return string
   *   URL of the file folder.
   */
  protected function pyhsicalToWebAddress($path) {
    return $this->webBasePathStr . substr(
          $path,
          $this->physicalBasePathStrLen
      );
  }

  /**
   * Short form of the web address for display.
   *
   * @param string $path
   *   Physical path of a file.
   *
   * @return string
   *   URL relative to public://.
   */
  protected function physicalToShortWebAddress($path) {
    return substr(
          $path,
          $this->physicalBasePathStrLen
      );
  }

  /**
   * Is the file writable? Used to filter the array of files.
   *
   * @param string $obj
   *   Object containing the path of a file.
   *
   * @return bool
   *   Whether the file is writable.
   */
  protected function writable($obj) {
    return is_writable($obj['path']);
  }

}
