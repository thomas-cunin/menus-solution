<?php

// src/Admin/Field/TinyMCEField.php

namespace App\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class TinyMCEField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/field/tinymce.html.twig')
            ->setFormType(TextareaType::class)
            ->addCssClass('field-tinymce')
            ->addWebpackEncoreEntries('tinymce-init');
    }
}
