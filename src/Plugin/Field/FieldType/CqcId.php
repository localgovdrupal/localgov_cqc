<?php declare(strict_types = 1);

namespace Drupal\localgov_cqc\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'localgov_cqc_id' field type.
 *
 * @FieldType(
 *   id = "localgov_cqc_id",
 *   label = @Translation("CQC ID"),
 *   category = @Translation("General"),
 *   default_widget = "localgov_cqc_id_widget",
 *   default_formatter = "localgov_cqc_location_widget",
 * )
 */
final class CqcId extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return match ($this->get('id')->getValue()) {
      NULL, '' => TRUE,
      default => FALSE,
    };
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {

    $properties = [];
    $properties['id'] = DataDefinition::create('string')
      ->setLabel(t('CQC ID'))
      ->setDescription(t('Care Quality Commission ID. Example 1-1000000'))
      ->setRequired(TRUE);
    $properties['type'] = DataDefinition::create('string')
      ->setLabel(t('ID type'))
      ->setDescription(t('Either location or provider'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $constraint_manager = $this->getTypedDataManager()->getValidationConstraintManager();

    // I've not found any definition of the ID. So far as I can tell if it's a location
    // they all presently have 1- at the start and this required. Providers
    // can, but don't all.
    $options = [];
    $options['id']['Regex']['pattern'] = '/^[A-Za-z0-9\-]+$/';
    $options['type']['Regex']['pattern'] = '/^(?:location|provider)$/';
    $constraints[] = $constraint_manager->create('ComplexData', $options);
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {

    $columns = [
      'id' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => 'CQC ID.',
        'length' => 32,
      ],
      'type' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => 'Type.',
        'length' => 16,
      ],
    ];

    $schema = [
      'columns' => $columns,
      'indexes' => [
        'id' => ['id'],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition): array {
    // Example ID from API documentation.
    return [
      'value' => '1-545611283',
      'type' => 'location',
    ];
  }

}
