<div class="form-checkbox">
    <input
        id="filters-item-{{ $item->id }}"
        type="checkbox"
        name="filters[brands][{{ $item->id }}]"
        value="{{ $item->id }}"
        @checked(request('filters.brands.' . $item->id))
    >
    <label for="filters-item-{{ $item->id }}" class="form-checkbox-label">{{ $item->name }}</label>
</div>
