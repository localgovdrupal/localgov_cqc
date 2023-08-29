<?php

namespace Drupal\localgov_cqc\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\CompositeFormElementTrait;
use Drupal\Core\Render\Element\FormElement;

/**
 * Provides form Element for a CQC ID.
 *
 * @FormElement("cqc_id_field")
 */
class CqcIdField extends FormElement {

  use CompositeFormElementTrait;

  /**
   * {@inheritdoc}
   */
  public function getInfo(): array {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#process' => [
        [$class, 'elementProcess'],
      ],
      '#theme_wrappers' => ['fieldset'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function elementProcess(array &$element, FormStateInterface $form_state, array &$complete_form): array {
    $element['#tree'] = TRUE;
    $element['#input'] = TRUE;

    $element['id'] = [
      '#title' => t('Id'),
      '#description' => t('CQC ID. Formatted like 1-000000.'),
      '#type' => 'textfield',
      '#required' => (!empty($element['#required'])) ? $element['#required'] : FALSE,
      '#default_value' => (isset($element['#default_value']['id'])) ? $element['#default_value']['id'] : '',
      '#attributes' => [
        'class' => ['cqcidfield-value'],
      ],
    ];

    $element['type'] = [
      '#title' => t('Type'),
      '#type' => 'select',
      '#options' => [
        'location' => t('Location'),
        'provider' => t('Provider'),
      ],
      '#required' => (!empty($element['#required'])) ? $element['#required'] : FALSE,
      '#default_value' => (isset($element['#default_value']['type'])) ? $element['#default_value']['type'] : 'location',
      '#attributes' => [
        'class' => ['cqcidfield-type'],
      ],
    ];

    unset($element['#value']);
    // Set this to false always to prevent notices.
    $element['#required'] = FALSE;

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function valueCallback(&$element, $input, FormStateInterface $form_state) {
    if ($input === FALSE) {
      $input = $element['#default_value'];
    }
    if (empty($input['id'])) {
      $input['type'] = '';
    }

    return $input;
  }

}
