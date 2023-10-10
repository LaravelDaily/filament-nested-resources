<?php

namespace App\Filament\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @property string|null $relationshipKey Define custom relationship key (if it does not match the table name pattern).
 */
trait HasParentResource
{
    public Model|int|string|null $parent = null;

    public function bootHasParentResource(): void
    {
        // Retrieve the parent resource's model.
        if ($parent = (request()->route('parent') ?? request()->input('parent'))) {
            $parentResource = $this->getParentResource();

            $this->parent = $parentResource::resolveRecordRouteBinding($parent);

            if (!$this->parent) {
                throw new ModelNotFoundException();
            }
        }
    }

    public function getParentResource(): string
    {
        if (!isset(static::$parentResource)) {
            throw new Exception('Parent resource is not set for ' . static::class);
        }

        return static::$parentResource;
    }

    protected function applyFiltersToTableQuery(Builder $query): Builder
    {
        return $query->where($this->getParentRelationshipKey(), $this->parent->getKey());
    }

    public function getParentRelationshipKey(): string
    {
        // You can set Custom relationship key (if it does not match the table name pattern) via $relationshipKey property.
        // Otherwise, it will be auto-resolved.
        return $this->relationshipKey ?? str($this->parent?->getTable())->singular()->append('_id')->toString();
    }

    public function getBreadcrumbs(): array
    {
        $resource = $this->getResource();
        $parentResource = $this->getParentResource();

        $breadcrumbs = [
            $parentResource::getUrl() => $parentResource::getBreadCrumb(),
            '#parent' => $parentResource::getRecordTitle($this->parent),

            $parentResource::getUrl($resource::getPluralModelLabel() . '.index', [
                'parent' => $this->parent,
            ]) => $resource::getBreadCrumb(),
        ];

        if (isset($this->record)) {
            $breadcrumbs['#'] = $resource::getRecordTitle($this->record);
        }

        $breadcrumbs[] = $this->getBreadCrumb();

        return $breadcrumbs;
    }
}
