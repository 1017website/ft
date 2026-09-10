<div class="repeater-item" data-item>
    <div class="item-toolbar">
        <strong data-item-title><span class="item-number" data-number>{{ is_numeric($index) ? $index + 1 : '' }}</span>{{ $group['label'] }}</strong>
        <div>
            <button type="button" class="quiet" data-move="up" aria-label="Pindahkan item ke atas">Naik</button>
            <button type="button" class="quiet" data-move="down" aria-label="Pindahkan item ke bawah">Turun</button>
            <button type="button" class="danger" data-remove>Hapus</button>
        </div>
    </div>
    <div class="field-grid">
    @foreach($group['fields'] as $key => $field)
        @include('admin.field', ['name' => "groups[$groupKey][$index][$key]", 'value' => $item[$key] ?? ''])
    @endforeach
    </div>
</div>
