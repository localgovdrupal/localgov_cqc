<?php declare(strict_types = 1);

namespace Drupal\localgov_cqc\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'localgov_cqc_id_widget' field widget.
 *
 * @FieldWidget(
 *   id = "localgov_cqc_id_widget",
 *   label = @Translation("CQC ID"),
 *   field_types = {"localgov_cqc_id"},
 * )
 */
final class CqCIdWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element['#type'] = 'cqc_id_field';
    $element['#default_value'] = isset($items[$delta]) ? $items[$delta]->getValue() : NULL;
    return $element;
  }

}
