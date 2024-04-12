@section('title', 'Title')
<x-app>
    <h3 class="page-title">保険者登録</h3>
        @include('components.session')
        @include('components.form-error')
            @if(empty($insurance->id))
            {!! Form::model($insurance, ['route' => ['insurance.store'], 'class' => '', 'accept-charset' => 'utf-8']) !!}
            @else
            {!! Form::model($insurance, ['route' => ['insurance.update', $insurance], 'class' => '', 'accept-charset' => 'utf-8','method' => 'put']) !!}
            @endif

    <div class="ms-2">
        <!-- 保険者番号 -->
        <div class="mb-4">
            <label for="number-hokenja" class="form-label label-sm">
                保険者番号<span class="required">必須</span>
            </label>
            {!! Form::text('code', old('code'), ['required' => 'required','class' => 'form-control w-50','id'=>'number-hokenja']) !!}
        </div>
        <!-- 保険者名 -->
        <div class="mb-4">
            <label for="name-hokenja" class="form-label label-sm">
                保険者名<span class="required">必須</span>
            </label>
            {!! Form::text('name', old('name'), ['required' => 'required','class' => 'form-control w-50','id'=>'name-hokenja']) !!}
        </div>
        <!-- 保険種別 -->
        <div class="mb-4">
            <div class="label-sm mb-2">保険種別<span class="required">必須</span></div>
            @foreach(code('hoken_kind_kbn')->pluck('value','key') as $key => $name)
                <div class="form-check ms-3">
                    <label class="form-check-label">
                        {!! Form::radio('type', $key, old('type', $insurance->type) == $key, ['class' => 'form-check-input']) !!}
                        {{ $name }}
                    </label>
                </div>
            @endforeach

        </div>
        <!-- 表示/非表示 -->
        <div class="label-sm mb-2">表示／非表示</div>
        <div class="form-check ms-3">
            <label class="form-check-label">
                {!! Form::booleanbox('is_not_display', 1, old('is_not_display', $insurance->is_not_display) == 1, ['class' => 'form-check-input']) !!}
                非表示
            </label>
        </div>
    </div>
    <!-- 画面遷移ボタン -->
    <div class="row mt-3 mb-5 ms-2 d-flex justify-content-center">
        <div class="col-3">
            @if(empty($insurance->id))
                <input class="btn search-btn me-2 w-100" name="submit" value="登録" type="submit" id="form_submit"/>
            @else
                <input class="btn search-btn me-2 w-100" name="submit" value="更新する" type="submit" id="form_submit"/>
            @endif

        </div>
        <div class="col-2">
            <a href="{{ route('insurance.index') }}"><button type="button" class="btn btn-outline-secondary clear-btn w-100">キャンセル</button></a>
        </div>
    </div>
        {!! Form::close() !!}
</x-app>
