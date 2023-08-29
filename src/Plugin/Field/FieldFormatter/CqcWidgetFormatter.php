<?php declare(strict_types = 1);

namespace Drupal\localgov_cqc\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'CQC Widget' formatter.
 *
 * @FieldFormatter(
 *   id = "localgov_cqc_widget_formatter",
 *   label = @Translation("CQC Widget"),
 *   field_types = {"localgov_cqc_id"},
 * )
 */
final class CqcWidgetFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#type' => 'inline_template',
        '#template' => '<script type="text/javascript"
src="//www.cqc.org.uk/sites/all/modules/custom/cqc_widget/widget.js?
data-id={{ id }}&data-host=www.cqc.org.uk&type={{ type }}"></script>',
        '#context' => [
          'id' => $item->id,
          'type' => $item->type,
        ],
      ];
    }
    return $element;
  }

}
