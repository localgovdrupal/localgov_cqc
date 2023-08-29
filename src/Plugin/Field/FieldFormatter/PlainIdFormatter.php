<?php declare(strict_types = 1);

namespace Drupal\localgov_cqc\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'CQC Widget' formatter.
 *
 * @FieldFormatter(
 *   id = "localgov_cqc_plain_formatter",
 *   label = @Translation("Plain text"),
 *   field_types = {"localgov_cqc_id"},
 * )
 */
final class PlainIdFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#plain_text' => $item->type . ': ' . $item->id,
      ];
    }
    return $element;
  }

}
