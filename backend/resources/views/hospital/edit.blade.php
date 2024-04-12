@section('title', 'Title')
<x-app>
    <h3 class="page-title">医療機関登録</h3>
        @include('components.session')
        @include('components.form-error')
            @if(empty($hospital->id))
            {!! Form::model($hospital, ['route' => ['hospital.store'], 'class' => '', 'accept-charset' => 'utf-8']) !!}
            @else
            {!! Form::model($hospital, ['route' => ['hospital.update', $hospital], 'class' => '', 'accept-charset' => 'utf-8','method' => 'put']) !!}
            @endif

    <div class="ms-2">
        <!-- 医療機関コード -->
        <div class="mb-4 was-validated">
            <label for="code-hospitals" class="form-label label-sm">
                医療機関コード<span class="required">必須</span>
            </label>
            {!! Form::text('code', old('code'), ['required' => 'required','class' => 'form-control w-50 is-invalid','id'=>'code-hospitals']) !!}
            <p class="invalid-feedback help-block"></p>
        </div>
        <!-- 医療機関名 -->
        <div class="mb-4">
            <label for="name-hospitals" class="form-label label-sm">
                医療機関名<span class="required">必須</span>
            </label>
            {!! Form::text('name', old('name'), ['required' => 'required','class' => 'form-control w-50','id'=>'name-hospitals']) !!}
        </div>
        <!-- 郵便番号 -->
        <div class="mb-4">
            <label for="postalCode-hospitals" class="form-label label-sm">郵便番号</label>
            {!! Form::text('postal_code', old('postal_code'), ['class' => 'form-control w-50']) !!}
        </div>
        <!-- 住所 -->
        <div class="mb-4">
            <label for="addr-hospitals" class="form-label label-sm">住所</label>
            {!! Form::text('address', old('address'), ['class' => 'form-control w-75','id'=>'addr-hospitals']) !!}
        </div>
        <!-- 電話番号 -->
        <div class="mb-4">
            <label for="tell-hospitals" class="form-label label-sm">電話番号</label>
            {!! Form::text('tel', old('tel'), ['class' => 'form-control w-50','id'=>'tel-hospitals']) !!}
        </div>
        <!-- 医療機関種別 -->
        <div class="mb-4">
            <div class="label-sm mb-2">医療機関種別<span class="required">必須</span></div>
            @foreach(code('hospital_type')->pluck('value','key') as $key => $name)
                <div class="form-check ms-3">
                    <label class="form-check-label">
                        {!! Form::radio('type', $key, old('type', $hospital->type) == $key, ['class' => 'form-check-input']) !!}
                        {{ $name }}
                    </label>
                </div>
            @endforeach

        </div>
        <!-- 表示/非表示 -->
        <div class="label-sm mb-2">表示／非表示</div>
        <div class="form-check ms-3">
            <label class="form-check-label">
            {!! Form::booleanbox('is_not_display', 1, old('is_not_display', $hospital->is_not_display) == 1, ['class' => 'form-check-input']) !!}
                非表示
            </label>
        </div>
    </div>
    </div>
    <!-- 画面遷移ボタン -->
    <div class="row mt-3 mb-5 ms-2 d-flex justify-content-center">
        <div class="col-3">
            @if(empty($hospital->id))
                <input class="btn search-btn me-2 w-100" name="submit" value="登録" type="submit" id="form_submit"/>
            @else
                <input class="btn search-btn me-2 w-100" name="submit" value="更新する" type="submit" id="form_submit"/>
            @endif
        </div>
        <div class="col-2">
            <a href="{{ route('hospital.index') }}"><button type="button" class="btn btn-outline-secondary clear-btn w-100">キャンセル</button></a>
        </div>
    </div>
        <nav class="text-center">
        </nav>
        {!! Form::close() !!}
    </div>
        </div>
    </div>
</x-app>
